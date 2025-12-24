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

    public function Customer($idCustomer)
    {
        return $this->customerRepository->getCustomer($idCustomer);
    }

    // create new customer
    public function createNewCustomer($dataNewCustomer){
        try {
            DB::beginTransaction();
            // TO DO SAVE INFO USER ROLE CUSTOMER
            $this->authRepository->saveUser($dataNewCustomer);
            // TO BO SAVE INFO PROFIL CUSTOMER
            $this->customerRepository->save($dataNewCustomer);
            // SEND EMAIL CUSTOMER
            $email = $dataNewCustomer['email'];
            $data = $dataNewCustomer;
            $this->sendMail->sendMailAfterSaveCustomer($email, $data);
            DB::commit();
            return true;
        } catch (Exception $e){
            DB::rollBack();
            \Log::error('Erreur lors de la sauvegarde du client : ' . $e->getMessage());
            return false;
        }
    }

    public function UpdateProfileCustomer($customer)
    {
        try {
            DB::beginTransaction();
            // TO DO SAVE INFO USER ROLE CUSTOMER
            $this->customerRepository->update($customer);

            DB::commit();
            return true;

        } catch (Exception $e){
            DB::rollBack();
            \Log::error('Erreur lors de la mise a jour du customer : ' . $e->getMessage());
            return false;
        }
    }

    public function UpdateAccountCustomer($Customer)
    {
        try {
            DB::beginTransaction();
            // TO DO SAVE INFO USER ROLE CUSTOMER
            $this->authRepository->updateUser($Customer);

            DB::commit();
            return true;

        } catch (Exception $e){
            DB::rollBack();
            \Log::error('Erreur lors de la mise a jour du customer : ' . $e->getMessage());
            return false;
        }
    }

    public function listCustmer()
    {
        return $this->customerRepository->allCustomer();
    }

    public function verifyUserExist($user_email)
    {return $this->authRepository->userExist($user_email);}

    public function saveNewPassword($user_email, $password)
    {return $this->authRepository->makeResetPassword($user_email, $password);}

    public function createWithdrawalAccount($dataWithdrawalAccount)
    {
        try {
            DB::beginTransaction();
            // TO DO SAVE INFO USER ROLE CUSTOMER
            $this->customerRepository->saveWithdrawalAccount($dataWithdrawalAccount);

            DB::commit();
            return true;

        } catch (Exception $e){
            DB::rollBack();
            \Log::error('Erreur lors de la creation du compte de retrait: ' . $e->getMessage());
            return false;
        }
    }

    public function listWithdrawalAccountByCustomer($idCustomer)
    {
        try {
            return $this->customerRepository->listWithdrawalAccountByCustomer($idCustomer);
        } catch (Exception $e){
            \Log::error('Erreur lors de la recuperation des comptes de retrait: ' . $e->getMessage());
            return false;
        }

    }
}