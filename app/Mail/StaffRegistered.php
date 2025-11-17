<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StaffRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $first_name;
    public $email;
    public $password;

    public function __construct($first_name, $email, $password)
    {
        $this->first_name = $first_name;
        $this->email = $email;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Your account has been created')
            ->markdown('emails.staff.registered'); // your Markdown view
    }
}

