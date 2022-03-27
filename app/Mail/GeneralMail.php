<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GeneralMail extends Mailable
{
    use Queueable, SerializesModels;

    public $maildata;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($maildata)
    {
        $this->maildata = $maildata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (array_key_exists('attachment', $this->maildata) && $this->maildata['attachment'] != "" && $this->maildata['attachment'] != null)
        {
            return $this->subject($this->maildata['subject'])
                ->markdown('emails.general_mail')
                ->attach($this->maildata['attachment'])
                ->with('maildata', $this->maildata);
        }
        return $this->subject($this->maildata['subject'])
            ->markdown('emails.general_mail')
            ->with('maildata', $this->maildata);
    }
}
