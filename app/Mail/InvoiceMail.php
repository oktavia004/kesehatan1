<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $pdf;

    public function __construct($order)
    {
        $this->order = $order;

        // load view invoice PDF
        $this->pdf = Pdf::loadView('invoices.invoice', [
            'order' => $order,
            'orderItems' => $order->items
        ]);
    }

    public function build()
    {
        return $this->subject('Invoice Pesanan #' . $this->order->order_id)
                    ->view('emails.invoice') // isi email (bukan PDF)
                    ->attachData(
                        $this->pdf->output(),
                        "invoice_{$this->order->order_id}.pdf"
                    );
    }
}
