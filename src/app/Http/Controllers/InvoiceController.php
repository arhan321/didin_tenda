<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function download(Order $order)
    {
        if ((int) $order->user_id !== (int) Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke invoice ini.');
        }

        $order->load([
            'user',
            'package',
            'items',
            'addons',
            'payment',
        ]);

        $pdf = Pdf::loadView('frontend.invoice.pdf', [
            'order' => $order,
        ])->setPaper('a4', 'portrait');

        $fileName = 'Invoice-' . str_replace(['/', '\\'], '-', $order->invoice_number) . '.pdf';

        return $pdf->download($fileName);
    }
}