<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $invoiceData;
    public $recipientEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoiceData, $recipientEmail)
    {
        $this->invoiceData = $invoiceData;
        $this->recipientEmail = $recipientEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('แจ้งหนี้/ใบกำกับภาษี - ' . $this->invoiceData['docNumber'])
                    ->view('emails.invoice')
                    ->with([
                        'invoice' => $this->invoiceData,
                    ]);
    }
}
