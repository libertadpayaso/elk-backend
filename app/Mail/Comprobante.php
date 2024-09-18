<?php

namespace App\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class Comprobante extends Mailable

{
    use Queueable, SerializesModels;

    public function __construct($fecha, $hora, $pdf, $nombre)
    {
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->pdf = $pdf;
        $this->nombre = $nombre;
    }

    public function build()
    {
        return $this->subject('Comprobante de Compra')->view('mail.comprobante')->with([
            
            'fecha' => $this->fecha,
            'hora' => $this->hora,
            'nombre' => $this->nombre,

        ])->attach(public_path('pdf/'.$this->pdf), [

            'as' => $this->pdf,
            'mime' => 'application/pdf',
        ]);
    }
}
