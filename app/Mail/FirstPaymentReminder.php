<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FirstPaymentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    protected $pdfPath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking, $pdfPath)
    {
        $this->booking = $booking;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->subject('Tour Booking - First Payment Reminder')
                      ->view('emails.tour_first_payment_reminder');

        if (file_exists($this->pdfPath)) {
            $email->attach($this->pdfPath, [
                'as' => basename($this->pdfPath),
                'mime' => 'application/pdf',
            ]);
        }

        return $email;
    }

    // public function build()
    // {
    //     // return $this->view('view.name');
    //     return $this->subject('Tour Booking - First Payment Reminder')
    //                 ->view('emails.tour_first_payment_reminder')
    //                 ->attach(public_path('app/invoices/sample_invoice.pdf'), [
    //                     'as' => 'sample_invoice.pdf',
    //                     'mime' => 'application/pdf',
    //                 ]);                    
    // }
}
