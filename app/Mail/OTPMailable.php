<?php

namespace App\Mail;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OTPMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $otp;
    public $fecha;

    public function __construct(User $user, $otp)
    {
        $this->user = $user;
        $this->otp = $otp;
        $this->fecha = Carbon::now()->format('Y-m-d');
        $this->subject('Código de verificación de OTP');
    }
    

    public function build()
    {
        return $this->view('mail.OTP'); // Vista de correo electrónico
    }
}