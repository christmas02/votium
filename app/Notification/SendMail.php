<?php

namespace App\Notification;


use App\Mail\Inscriptioncustomer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMail
{
    public function sendMailAfterSaveCustomer($email, $data)
    {
        try{
            Log::info('methode SendMail - Enter in send mail service');
            Mail::to($email)->send(new Inscriptioncustomer($data));
            return true;
        }catch(\Throwable $th){
            Log::error($th->getMessage());
        }
    }
}
