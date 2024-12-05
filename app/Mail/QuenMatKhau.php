<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuenMatKhau extends Mailable
{
    use Queueable, SerializesModels;

    public $hash_reset;
    public $name;

    public function __construct($hash_reset, $name)
    {
        $this->hash_reset = $hash_reset;
        $this->name = $name;
    }
    public function build()
    {
        return $this->subject("Lấy lại mật khẩu")
            ->view('mail_quen_mat_khau', ['hash_reset' => $this->hash_reset, 'name' => $this->name]);
    }
}
