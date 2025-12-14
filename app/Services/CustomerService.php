<?php

namespace App\Services;

use App\Notification\SendMail;
use App\Repository\CustomerRepository;
use App\Repository\AuhRepository;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    protected $customerRepository;
    protected $authRepository;
    protected $sendMail;

    public function __construct(
        CustomerRepository $customerRepository,
        AuhRepository $authRepository,
        SendMail $sendMail)
    {
        $this->customerRepository = $customerRepository;
        $this->authRepository = $authRepository;
        $this->sendMail = $sendMail;
    }

    public function createNewCustomer($dataNewCustomer){
        try {
            DB::beginTransaction();
            // TO DO SAVE INFO USER ROLE CUSTOMER
            $this->authRepository->saveUser($dataNewCustomer);
            // TO BO SAVE INFO PROFIL CUSTOMER
            $this->customerRepository->save($dataNewCustomer);
            // SEND EMAIL CUSTOMER
            $email = $dataNewCustomer['email'];
            $user = $dataNewCustomer['name'];
            $data = "";
            $this->sendMail->sendMailAfterSaveCustomer($email, $user, $data);
            DB::commit();
            return true;
        } catch (Exception $e){
            \Log::error('Erreur lors de la sauvegarde du client : ' . $e->getMessage());
            return false;
            DB::rollBack();
        }
    }
}