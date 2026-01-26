<?php

namespace App\Sdkpayment;

use GuzzleHttp\Client;

class ClientHttpInstance
{

    private static $instance;
    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Client([
                'verify' => false,
                'timeout' => 30,
            ]);
        }
        return self::$instance;
    }



}