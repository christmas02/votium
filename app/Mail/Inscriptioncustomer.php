<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Inscriptioncustomer extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     *
     */
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
        //var_dump($this->user);
        return $this->from('no_reply@votium.com', 'VOTIUM')
            ->cc('christian.dev.alexis@gmail.com') // Remplacez par votre adresse email
            ->subject('Validation d inscription')
            ->markdown('mails.inscriptioncustomer');
    }

}