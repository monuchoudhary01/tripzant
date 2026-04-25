<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FlightTicketMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $booking;
    public $pdfData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking, $pdfData)
    {
        $this->booking = $booking;
        $this->pdfData = $pdfData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Flight Booking Confirmation - ' . $this->booking->booking_reference)
                    ->view('emails.flight-ticket')
                    ->attachData($this->pdfData, 'E-Ticket-' . $this->booking->booking_reference . '.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
