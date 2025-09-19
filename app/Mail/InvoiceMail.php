<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf;
    public $order;

    public function __construct($pdf, $order)
    {
        $this->pdf = $pdf;
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Invoice Anda dari Toko Alat Kesehatan')
                    ->view('emails.invoice')
                    ->attachData($this->pdf->output(), 'invoice-'.$this->order->order_id.'.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
