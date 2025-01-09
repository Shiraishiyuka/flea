<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TwoFactorCode extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code, $token)
    {
        $this->code = $code;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
{
    return $this->subject('二段階認証リンク')
        ->view('emails.two_factor_code')
        ->with([
            'url' => url('/verify/' . $this->token), // トークン付き認証リンク
        ]);
}
}
