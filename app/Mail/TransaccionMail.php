<?php

namespace App\Mail;

use App\Transaccion;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransaccionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $transacciones;
    public $tipo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $transacciones)
    {
        $this->user = $user;
        $this->transacciones = $transacciones;
        $this->tipo = 'especifico';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.reportes.estado_cuenta');
    }
}
