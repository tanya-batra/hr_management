<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OfferLetterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;
    public $pdfPath;

    public function __construct($employee, $pdfPath)
    {
        $this->employee = $employee;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->subject('Your Offer Letter')
                    ->view('emails.offer_letter')
                    ->attach($this->pdfPath, [
                        'as' => 'Offer_Letter.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}