<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class ReviewController extends Controller
{
    public function store(Request $request, Order $order)
    {
        if ((int) $order->user_id !== (int) Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        if ($order->status !== 'completed') {
            return response()->json([
                'status' => false,
                'message' => 'Review hanya bisa diberikan setelah pesanan selesai.',
            ], 422);
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['nullable', 'string', 'max:1000'],
        ]);

        $review = Review::updateOrCreate(
            [
                'order_id' => $order->id,
            ],
            [
                'user_id' => Auth::id(),
                'rating' => $validated['rating'],
                'review' => $validated['review'] ?? null,
                'is_visible' => true,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Review berhasil disimpan. Terima kasih atas penilaian Anda.',
            'review' => [
                'rating' => $review->rating,
                'review' => $review->review,
            ],
        ]);
    }
}
