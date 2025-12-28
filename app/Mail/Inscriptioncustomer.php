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
        ->subject('Votre compte a été créé')
        ->markdown('mails.inscriptioncustomer')
        ->with([
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'defaultPassword' => '12345678Aa',
        ]);
    }

}