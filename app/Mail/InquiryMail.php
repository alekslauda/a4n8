<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;

    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    public function build()
    {
      return $this->subject("Inquiry: #{$this->inquiry->id} created!")
      ->view('emails.inquiry')
      ->with([
          'name' => $this->inquiry->name,
          'email' => $this->inquiry->email,
          'phone' => $this->inquiry->phone,
          'message' => $this->inquiry->message
      ]);
    }
}
