<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class InvoicePaidMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        $this->order->loadMissing([
            'user',
            'package',
            'items',
            'addons',
            'payment',
        ]);

        $pdf = Pdf::loadView('frontend.invoice.pdf', [
            'order' => $this->order,
        ])->setPaper('a4', 'portrait');

        $fileName = 'Invoice-'.str_replace(['/', '\\'], '-', $this->order->invoice_number).'.pdf';

        return $this
            ->subject('Invoice Pembayaran '.$this->order->invoice_number.' - Didin Tenda Decoration')
            ->view('emails.invoice-paid')
            ->with([
                'order' => $this->order,
            ])
            ->attachData($pdf->output(), $fileName, [
                'mime' => 'application/pdf',
            ]);
    }
}
