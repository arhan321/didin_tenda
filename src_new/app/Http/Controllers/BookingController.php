<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\CustomItem;
use App\Models\Order;
use App\Models\Package;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

final class BookingController extends Controller
{
    public function index()
    {
        $cart = session('booking_cart', []);
        $totals = $this->calculateCartTotals($cart);
        $cartCount = count($cart);

        return view('frontend.cart', compact('cart', 'totals', 'cartCount'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'package_id' => ['required', 'exists:packages,id'],

            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'event_location_name' => ['required', 'string', 'max:255'],
            'event_address' => ['required', 'string'],

            // Koordinat titik lokasi acara dari map
            'event_latitude' => ['required', 'numeric', 'between:-90,90'],
            'event_longitude' => ['required', 'numeric', 'between:-180,180'],

            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'customer_email' => ['nullable', 'email', 'max:255'],

            'notes' => ['nullable', 'string'],

            'addons' => ['nullable', 'array'],
            'addons.*.quantity' => ['nullable', 'integer', 'min:0'],

            // Dari frontend boleh dikirim, tapi backend tetap hitung ulang
            'distance_km' => ['nullable', 'numeric', 'min:0'],
            'shipping_fee' => ['nullable', 'integer', 'min:0'],

            'checkout_now' => ['nullable'],
        ]);

        $package = Package::with('items')
            ->where('id', $validated['package_id'])
            ->where('type', 'fixed')
            ->where('is_active', true)
            ->firstOrFail();

        if ($this->isDateBooked($package->id, $validated['event_date'])) {
            return back()
                ->withInput()
                ->with('error', 'Tanggal tersebut sudah dibooking untuk paket ini. Silakan pilih tanggal lain.');
        }

        $selectedAddons = $this->prepareSelectedAddons($request->input('addons', []));
        $subtotalAddons = collect($selectedAddons)->sum('total_price');

        // Hitung ulang jarak dari koordinat memakai OSRM
        $distanceKm = $this->getDistanceFromCoordinates(
            (float) config('didin.depot_lat', -6.262311),
            (float) config('didin.depot_lng', 106.472969),
            (float) $validated['event_latitude'],
            (float) $validated['event_longitude']
        );

        // Fallback 1: pakai jarak dari frontend jika OSRM gagal
        if (! $distanceKm || $distanceKm <= 0) {
            $distanceKm = $request->filled('distance_km')
                ? (float) $validated['distance_km']
                : 0;
        }

        // Fallback 2: hitung garis lurus x 1.25 jika masih kosong
        if (! $distanceKm || $distanceKm <= 0) {
            $distanceKm = $this->calculateStraightDistance(
                (float) config('didin.depot_lat', -6.262311),
                (float) config('didin.depot_lng', 106.472969),
                (float) $validated['event_latitude'],
                (float) $validated['event_longitude']
            ) * 1.25;
        }

        $distanceKm = round($distanceKm, 2);

        // Ongkir selalu dihitung ulang di backend
        $shippingFee = $this->calculateShippingFee($distanceKm);

        $subtotalPackage = (int) $package->price;
        $totalPrice = $subtotalPackage + $subtotalAddons + $shippingFee;

        $cartItem = [
            'key' => (string) Str::uuid(),
            'order_type' => 'package',

            'package' => [
                'id' => $package->id,
                'slug' => $package->slug,
                'name' => $package->name,
                'price' => (int) $package->price,
                'price_unit' => $package->price_unit,
                'main_image' => $package->main_image,
                'short_description' => $package->short_description,
            ],

            'customer_name' => $validated['customer_name'],
            'customer_phone' => $this->normalizePhone($validated['customer_phone']),
            'customer_email' => $validated['customer_email'] ?? Auth::user()?->email,

            'event_date' => $validated['event_date'],
            'event_location_name' => $validated['event_location_name'],
            'event_address' => $validated['event_address'],

            // Koordinat dari map
            'event_latitude' => $validated['event_latitude'],
            'event_longitude' => $validated['event_longitude'],

            'distance_km' => $distanceKm,
            'shipping_fee' => $shippingFee,

            'addons' => $selectedAddons,

            'subtotal_package' => $subtotalPackage,
            'subtotal_custom' => 0,
            'subtotal_addons' => $subtotalAddons,
            'total_price' => $totalPrice,

            'notes' => $validated['notes'] ?? null,
        ];

        if ($request->boolean('checkout_now')) {
            if (! Auth::check()) {
                $cart = session('booking_cart', []);
                $cart[$cartItem['key']] = $cartItem;
                session(['booking_cart' => $cart]);

                return redirect()
                    ->route('frontend.index')
                    ->with('error', 'Silakan login terlebih dahulu untuk melanjutkan booking dan pembayaran.');
            }

            $order = DB::transaction(function () use ($cartItem) {
                return $this->createOrderFromCartItem($cartItem);
            });

            return redirect()
                ->route('frontend.pesanan')
                ->with('success', 'Booking berhasil dibuat. Silakan lanjutkan pembayaran untuk invoice '.$order->invoice_number.'.');
        }

        $cart = session('booking_cart', []);
        $cart[$cartItem['key']] = $cartItem;

        session(['booking_cart' => $cart]);

        return redirect()
            ->route('frontend.cart')
            ->with('success', 'Paket berhasil ditambahkan ke keranjang.');
    }

    public function remove(string $key)
    {
        $cart = session('booking_cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session(['booking_cart' => $cart]);
        }

        return redirect()
            ->route('frontend.cart')
            ->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget('booking_cart');

        return redirect()
            ->route('frontend.cart')
            ->with('success', 'Keranjang berhasil dikosongkan.');
    }

    public function checkout()
    {
        if (! Auth::check()) {
            return redirect()
                ->route('frontend.index')
                ->with('error', 'Silakan login terlebih dahulu untuk melanjutkan pembayaran.');
        }

        $cart = session('booking_cart', []);

        if (count($cart) === 0) {
            return redirect()
                ->route('frontend.cart')
                ->with('error', 'Keranjang masih kosong.');
        }

        try {
            $orders = DB::transaction(function () use ($cart) {
                $createdOrders = [];

                foreach ($cart as $cartItem) {
                    $orderType = $cartItem['order_type'] ?? 'package';

                    if ($orderType === 'package') {
                        $packageId = $cartItem['package']['id'] ?? null;

                        if (! $packageId) {
                            throw new Exception('Data paket tidak valid pada keranjang.');
                        }

                        if ($this->isDateBooked((int) $packageId, $cartItem['event_date'], 'package')) {
                            throw new Exception(
                                'Tanggal '.$cartItem['event_date'].' sudah dibooking. Silakan hapus item tersebut dan pilih tanggal lain.'
                            );
                        }
                    }

                    if ($orderType === 'custom') {
                        if ($this->isDateBooked(null, $cartItem['event_date'], 'custom')) {
                            throw new Exception(
                                'Tanggal '.$cartItem['event_date'].' sudah digunakan untuk paket custom. Silakan pilih tanggal lain.'
                            );
                        }
                    }

                    $createdOrders[] = $this->createOrderFromCartItem($cartItem);
                }

                return $createdOrders;
            });

            session()->forget('booking_cart');

            return redirect()
                ->route('frontend.pesanan')
                ->with('success', count($orders).' booking berhasil dibuat. Silakan lanjutkan pembayaran.');
        } catch (Throwable $error) {
            return redirect()
                ->route('frontend.cart')
                ->with('error', $error->getMessage());
        }
    }

    public function quickCheck(Request $request)
    {
        $validated = $request->validate([
            'package_id' => ['required', 'exists:packages,id'],
            'event_date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $package = Package::where('id', $validated['package_id'])
            ->where('is_active', true)
            ->firstOrFail();

        $available = ! $this->isDateBooked($package->id, $validated['event_date']);

        return response()->json([
            'status' => true,
            'available' => $available,
            'message' => $available
                ? 'Tanggal tersedia. Silakan lanjut booking.'
                : 'Tanggal sudah dibooking. Silakan pilih tanggal lain.',
            'package' => [
                'id' => $package->id,
                'slug' => $package->slug,
                'name' => $package->name,
                'price' => $package->price,
            ],
        ]);
    }

    public function count()
    {
        return response()->json([
            'count' => count(session('booking_cart', [])),
        ]);
    }

    public function addCustomToCart(Request $request)
    {
        $validated = $request->validate([
            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'event_location_name' => ['required', 'string', 'max:255'],
            'event_address' => ['required', 'string'],

            'event_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'event_longitude' => ['nullable', 'numeric', 'between:-180,180'],

            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'customer_email' => ['nullable', 'email', 'max:255'],

            'notes' => ['nullable', 'string'],

            'custom_items' => ['required', 'array', 'min:1'],
            'custom_items.*.id' => ['required', 'integer', 'exists:custom_items,id'],
            'custom_items.*.quantity' => ['required', 'integer', 'min:1'],

            'addons' => ['nullable', 'array'],

            'distance_km' => ['nullable', 'numeric', 'min:0'],
            'shipping_fee' => ['nullable', 'integer', 'min:0'],

            'checkout_now' => ['nullable'],
        ]);

        $customItemsPayload = collect($validated['custom_items']);

        $customItems = CustomItem::query()
            ->whereIn('id', $customItemsPayload->pluck('id'))
            ->where('is_active', true)
            ->get()
            ->keyBy('id');

        if ($customItems->count() !== $customItemsPayload->count()) {
            return response()->json([
                'status' => false,
                'message' => 'Beberapa item custom tidak ditemukan atau tidak aktif.',
            ], 422);
        }

        $selectedCustomItems = [];
        $subtotalCustom = 0;

        foreach ($customItemsPayload as $payloadItem) {
            $customItem = $customItems->get((int) $payloadItem['id']);
            $quantity = (int) $payloadItem['quantity'];

            if ($customItem->max_quantity !== null && $quantity > $customItem->max_quantity) {
                return response()->json([
                    'status' => false,
                    'message' => "Jumlah {$customItem->name} maksimal {$customItem->max_quantity} {$customItem->unit}.",
                ], 422);
            }

            if ($quantity < $customItem->min_quantity) {
                return response()->json([
                    'status' => false,
                    'message' => "Jumlah {$customItem->name} minimal {$customItem->min_quantity} {$customItem->unit}.",
                ], 422);
            }

            $totalPrice = (int) $customItem->price * $quantity;
            $subtotalCustom += $totalPrice;

            $selectedCustomItems[] = [
                'custom_item_id' => $customItem->id,
                'slug' => $customItem->slug,
                'name' => $customItem->name,
                'description' => $customItem->description,
                'unit' => $customItem->unit,
                'quantity' => $quantity,
                'price' => (int) $customItem->price,
                'total_price' => $totalPrice,
                'snapshot' => [
                    'slug' => $customItem->slug,
                    'image' => $customItem->image,
                    'icon' => $customItem->icon,
                    'unit' => $customItem->unit,
                ],
            ];
        }

        $selectedAddons = $this->prepareSelectedAddonsFlexible($request->input('addons', []));
        $subtotalAddons = collect($selectedAddons)->sum('total_price');

        $distanceKm = $request->filled('distance_km')
            ? (float) $validated['distance_km']
            : $this->estimateDistanceFromAddress($validated['event_address']);

        $shippingFee = $request->filled('shipping_fee')
            ? (int) $validated['shipping_fee']
            : $this->calculateShippingFee($distanceKm);

        $totalPrice = $subtotalCustom + $subtotalAddons + $shippingFee;

        $cartItem = [
            'key' => (string) Str::uuid(),
            'order_type' => 'custom',

            'package' => null,

            'customer_name' => $validated['customer_name'],
            'customer_phone' => $this->normalizePhone($validated['customer_phone']),
            'customer_email' => $validated['customer_email'] ?? Auth::user()?->email,

            'event_date' => $validated['event_date'],
            'event_location_name' => $validated['event_location_name'],
            'event_address' => $validated['event_address'],

            'event_latitude' => $validated['event_latitude'] ?? null,
            'event_longitude' => $validated['event_longitude'] ?? null,

            'distance_km' => round($distanceKm, 2),
            'shipping_fee' => $shippingFee,

            'custom_items' => $selectedCustomItems,
            'addons' => $selectedAddons,

            'subtotal_package' => 0,
            'subtotal_custom' => $subtotalCustom,
            'subtotal_addons' => $subtotalAddons,
            'total_price' => $totalPrice,

            'notes' => $validated['notes'] ?? null,
        ];

        if ($request->boolean('checkout_now')) {
            if (! Auth::check()) {
                $cart = session('booking_cart', []);
                $cart[$cartItem['key']] = $cartItem;
                session(['booking_cart' => $cart]);

                return response()->json([
                    'status' => false,
                    'message' => 'Silakan login terlebih dahulu untuk melanjutkan booking dan pembayaran.',
                    'redirect_url' => route('frontend.index'),
                ], 401);
            }

            $order = DB::transaction(function () use ($cartItem) {
                return $this->createOrderFromCartItem($cartItem);
            });

            return response()->json([
                'status' => true,
                'message' => 'Booking custom berhasil dibuat. Silakan lanjutkan pembayaran.',
                'redirect_url' => route('frontend.pesanan'),
                'invoice_number' => $order->invoice_number,
            ]);
        }

        $cart = session('booking_cart', []);
        $cart[$cartItem['key']] = $cartItem;

        session(['booking_cart' => $cart]);

        return response()->json([
            'status' => true,
            'message' => 'Paket Custom berhasil ditambahkan ke keranjang.',
            'cart_count' => count($cart),
            'redirect_url' => route('frontend.cart'),
        ]);
    }

    private function prepareSelectedAddons(array $addonsInput): array
    {
        $selected = [];

        foreach ($addonsInput as $addonId => $addonData) {
            $quantity = (int) ($addonData['quantity'] ?? 0);

            if ($quantity <= 0) {
                continue;
            }

            $addon = Addon::where('id', $addonId)
                ->where('is_active', true)
                ->first();

            if (! $addon) {
                continue;
            }

            if ($addon->stock !== null && $quantity > $addon->stock) {
                $quantity = $addon->stock;
            }

            $selected[] = [
                'addon_id' => $addon->id,
                'name' => $addon->name,
                'detail' => $addon->detail,
                'unit' => $addon->unit,
                'quantity' => $quantity,
                'price' => (int) $addon->price,
                'total_price' => (int) $addon->price * $quantity,
                'snapshot' => [
                    'slug' => $addon->slug,
                    'image' => $addon->image,
                    'icon' => $addon->icon,
                    'is_quantity_based' => $addon->is_quantity_based,
                ],
            ];
        }

        return $selected;
    }

    private function createOrderFromCartItem(array $cartItem): Order
    {
        $orderType = $cartItem['order_type'] ?? 'package';

        $order = Order::create([
            'invoice_number' => $this->generateInvoiceNumber(),
            'user_id' => Auth::id(),

            'package_id' => $orderType === 'package'
                ? ($cartItem['package']['id'] ?? null)
                : null,

            'order_type' => $orderType,

            'customer_name' => $cartItem['customer_name'],
            'customer_phone' => $cartItem['customer_phone'],
            'customer_email' => $cartItem['customer_email'] ?? Auth::user()?->email,

            'event_date' => $cartItem['event_date'],
            'event_location_name' => $cartItem['event_location_name'],
            'event_address' => $cartItem['event_address'],

            'event_latitude' => $cartItem['event_latitude'] ?? null,
            'event_longitude' => $cartItem['event_longitude'] ?? null,

            'distance_km' => $cartItem['distance_km'] ?? null,
            'shipping_fee' => $cartItem['shipping_fee'] ?? 0,

            'subtotal_package' => $cartItem['subtotal_package'] ?? 0,
            'subtotal_custom' => $cartItem['subtotal_custom'] ?? 0,
            'subtotal_addons' => $cartItem['subtotal_addons'] ?? 0,
            'total_price' => $cartItem['total_price'] ?? 0,

            'status' => 'waiting_payment',
            'payment_status' => 'unpaid',
            'payment_deadline' => now()->addDay(),

            'notes' => $cartItem['notes'] ?? null,
        ]);

        if ($orderType === 'package') {
            $order->items()->create([
                'item_type' => 'package',
                'source_id' => $cartItem['package']['id'] ?? null,
                'name' => $cartItem['package']['name'] ?? 'Paket',
                'unit' => $cartItem['package']['price_unit'] ?? 'paket',
                'quantity' => 1,
                'price' => $cartItem['subtotal_package'] ?? 0,
                'total_price' => $cartItem['subtotal_package'] ?? 0,
                'snapshot' => $cartItem['package'],
            ]);
        }

        if ($orderType === 'custom') {
            foreach (($cartItem['custom_items'] ?? []) as $customItem) {
                $order->items()->create([
                    'item_type' => 'custom',
                    'source_id' => $customItem['custom_item_id'] ?? null,
                    'name' => $customItem['name'],
                    'unit' => $customItem['unit'] ?? 'pcs',
                    'quantity' => (int) $customItem['quantity'],
                    'price' => (int) $customItem['price'],
                    'total_price' => (int) $customItem['total_price'],
                    'snapshot' => $customItem['snapshot'] ?? $customItem,
                ]);
            }
        }

        foreach (($cartItem['addons'] ?? []) as $addon) {
            $order->addons()->create([
                'addon_id' => $addon['addon_id'] ?? null,
                'name' => $addon['name'],
                'detail' => $addon['detail'] ?? null,
                'unit' => $addon['unit'] ?? null,
                'quantity' => $addon['quantity'],
                'price' => $addon['price'],
                'total_price' => $addon['total_price'],
                'snapshot' => $addon['snapshot'] ?? null,
            ]);
        }

        return $order;
    }

    private function calculateCartTotals(array $cart): array
    {
        return [
            'subtotal_package' => collect($cart)->sum('subtotal_package'),
            'subtotal_custom' => collect($cart)->sum('subtotal_custom'),
            'subtotal_addons' => collect($cart)->sum('subtotal_addons'),
            'shipping_fee' => collect($cart)->sum('shipping_fee'),
            'grand_total' => collect($cart)->sum('total_price'),
        ];
    }

    private function isDateBooked(?int $packageId, string $eventDate, string $orderType = 'package'): bool
    {
        $query = Order::query()
            ->whereDate('event_date', $eventDate)
            ->whereNotIn('status', ['cancelled', 'expired']);

        if ($orderType === 'package') {
            $query->where('package_id', $packageId);
        }

        if ($orderType === 'custom') {
            $query->where('order_type', 'custom');
        }

        return $query->exists();
    }

    private function generateInvoiceNumber(): string
    {
        do {
            $number = 'INV/'.now()->format('Y').'/'.
                mb_str_pad(
                    (string) (Order::whereYear('created_at', now()->year)->count() + 1),
                    4,
                    '0',
                    STR_PAD_LEFT
                ).
                '-'.mb_strtoupper(Str::random(4));
        } while (Order::where('invoice_number', $number)->exists());

        return $number;
    }

    private function getDistanceFromCoordinates(
        float $originLat,
        float $originLng,
        float $destinationLat,
        float $destinationLng
    ): ?float {
        try {
            $baseUrl = mb_rtrim(config('didin.osrm_base_url', 'https://router.project-osrm.org'), '/');

            $url = $baseUrl.'/route/v1/driving/'.
                $originLng.','.$originLat.';'.
                $destinationLng.','.$destinationLat;

            $response = Http::timeout(10)->get($url, [
                'overview' => 'false',
            ]);

            if (! $response->successful()) {
                return null;
            }

            $data = $response->json();

            if (
                ! isset($data['routes']) ||
                ! isset($data['routes'][0]) ||
                ! isset($data['routes'][0]['distance'])
            ) {
                return null;
            }

            return round($data['routes'][0]['distance'] / 1000, 2);
        } catch (Throwable $error) {
            return null;
        }
    }

    private function calculateStraightDistance(
        float $lat1,
        float $lng1,
        float $lat2,
        float $lng2
    ): float {
        $earthRadiusKm = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *
            sin($dLng / 2) *
            sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadiusKm * $c;
    }

    private function calculateShippingFee(float $distanceKm): int
    {
        if ($distanceKm <= 10) {
            return 0;
        }

        if ($distanceKm <= 30) {
            return (int) ceil($distanceKm - 10) * 5000;
        }

        return (20 * 5000) + ((int) ceil($distanceKm - 30) * 10000);
    }

    private function normalizePhone(string $phone): string
    {
        return preg_replace('/[^0-9+]/', '', $phone);
    }

    private function prepareSelectedAddonsFlexible(array $addonsInput): array
    {
        if (empty($addonsInput)) {
            return [];
        }

        $normalized = [];

        foreach ($addonsInput as $key => $value) {
            if (is_array($value) && isset($value['id'])) {
                $normalized[$value['id']] = [
                    'quantity' => $value['quantity'] ?? 0,
                ];

                continue;
            }

            $normalized[$key] = $value;
        }

        return $this->prepareSelectedAddons($normalized);
    }
}
