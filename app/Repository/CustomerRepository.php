<?php

namespace App\Repository;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerRepository
{
    public function save($dataCustomer): bool
    {
        try {
            $customer = new Customer();
            $customer->customer_id = $dataCustomer['customer_id'];
            $customer->user_id = $dataCustomer['user_id'];
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
            \Log::error('Erreur lors de la sauvegarde du client : ' . $e->getMessage());
            return false;
        }
    }
}