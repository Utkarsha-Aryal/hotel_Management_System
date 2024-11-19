<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountCreatedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $password;
    public $name;
    public $email;

    /**
     * Create a new message instance.
     */
    public function __construct($password, $post)
    {
        $this->password = $password;
        $this->name = $post['name'];
        $this->email = $post['email'];
    }

    /**
     * Get the message envelope.
     * 
     */

     public function build()
    {
        return $this->markdown('backend.emails.account-created-mail');
        //C:\xampp\htdocs\auth\resources\views\backend\emails\account-created-mail.blade.php
    }
   
}
