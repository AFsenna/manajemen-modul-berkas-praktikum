<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailGoogle extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->details['status'] == 1) {
            return $this->subject($this->details['subject'])->view('layouts.templateEmail.jadwal');
        } else if ($this->details['status'] == 2) {
            return $this->subject($this->details['subject'])->view('layouts.templateEmail.tolak');
        }
    }
}
