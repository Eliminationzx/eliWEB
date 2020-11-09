<?php

namespace App\Http\Controllers\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerificator extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		$username = $this->data['name'];
		$email = $this->data['email'];
		$token = $this->data['verify_token'];
		$sender = config('mail.from.name');		 
		return $this->to($email)->subject($sender)->markdown('vendor.mail.markdown.message', ['email' => $email, 'token' => $token, 'username' => $username]);
    }
}
