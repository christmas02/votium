<?php

namespace App\Repository;

use App\Models\Customer;
use App\Models\WithdrawalAccount;

class CustomerRepository
{
    public function getCustomer($idCustomer)
    {
        return Customer::where('customer_id', $idCustomer)->first();
    }

    public function getCustomerByIdUser($user_id)
    {
        return Customer::where('user_id', $user_id)->first();
    }

    public function allCustomer()
    {
        return Customer::all();
    }

    public function save($dataCustomer): bool
    {
        try {
            $customer = new Customer();
            $customer->customer_id = $dataCustomer['customer_id'];
            $customer->user_id = $dataCustomer['user_id'];
            $customer->entreprise = $dataCustomer['entreprise'];
            $customer->pays_siege = $dataCustomer['pays_siege'];
            $customer->email = $dataCustomer['email_customer'];
            $customer->phonenumber = $dataCustomer['phonenumber_customer'];
            $customer->adresse = $dataCustomer['adresse'];
            $customer->link_facebook = $dataCustomer['link_facebook'];
            $customer->link_instagram = $dataCustomer['link_instagram'];
            $customer->logo = $dataCustomer['logo'];
            $customer->link_linkedin = $dataCustomer['link_linkedin'];
            $customer->link_website = $dataCustomer['link_website'];
            $customer->link_tiktok = $dataCustomer['link_tiktok'];
            $customer->link_youtube = $dataCustomer['link_youtube'];
            return $customer->save();

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la sauvegarde du client : ' . $e->getMessage());
            return false;
        }
    }

    public function update($dataCustomer)
    {
        try {
            $customer = Customer::where('customer_id', $dataCustomer['customer_id'])->first();
            // TO DO UPDATE CUSTOMER INFO
            $customer->entreprise = $dataCustomer['entreprise'];
            $customer->pays_siege = $dataCustomer['pays_siege'];
            $customer->email = $dataCustomer['email'];
            $customer->phonenumber = $dataCustomer['phonenumber'];
            $customer->adresse = $dataCustomer['adresse'];
            $customer->link_facebook = $dataCustomer['link_facebook'];
            $customer->link_instagram = $dataCustomer['link_instagram'];
            $customer->logo = $dataCustomer['logo'];
            $customer->link_linkedin = $dataCustomer['link_linkedin'];
            $customer->link_website = $dataCustomer['link_website'];
            $customer->link_tiktok = $dataCustomer['link_tiktok'];
            $customer->link_youtube = $dataCustomer['link_youtube'];
            return $customer->save();
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise a jour  - file:CustomerRepository : ' . $e->getMessage());
            return false;
        }
    }

    public function saveWithdrawalAccount($dataWithdrawalAccount)
    {
        try {
            $account = new WithdrawalAccount();
            $account->withdrawal_account_id = $dataWithdrawalAccount['withdrawal_account_id'];
            $account->customer_id = $dataWithdrawalAccount['customer_id'];
            $account->phone_number = $dataWithdrawalAccount['phone_number'];
            $account->account_name = $dataWithdrawalAccount['account_name'];
            $account->payment_methode = $dataWithdrawalAccount['payment_methode'];
            $account->is_active = true;
            return $account->save();

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la sauvegarde du compte de retrait - file:CustomerRepository  : ' . $e->getMessage());
            return false;
        }
    }

    public function archiveWithdrawalAccount($dataWithdrawalAccount)
    {
        try {
            $account = WithdrawalAccount::where('withdrawal_account_id', $dataWithdrawalAccount['withdrawal_account_id'])->first();
            $account->is_active = false;
            return $account->save();

        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'archivage du compte de retrait - file:CustomerRepository  : ' . $e->getMessage());
            return false;
        }
    }

    public function listWithdrawalAccountByCustomer($idCustomer)
    {
        try {
            return  WithdrawalAccount::where('customer_id', $idCustomer)->get();
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la recuperation des comptes de retrait - file:CustomerRepository  : ' . $e->getMessage());
            return false;
        }
    }
}