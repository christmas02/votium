<?php

namespace App\Repository;

use App\Models\Account;
class AccountRepository
{
    public function getAccountBalance($accountId)
    {
        // Simulate fetching account balance from a database or external service
        $balances = [
            'account1' => 1000.00,
            'account2' => 2500.50,
            'account3' => 500.75,
        ];

        return $balances[$accountId] ?? null;
    }
    
    public function updateAccountBalance($accountId, $amount)
    {
        // Simulate updating account balance in a database or external service
        // In a real implementation, you would perform a database update here
        return true; // Assume the update was successful
    }
    
    public function getAccountByCustomer($customer_id)
    {
        try {
            $account = Account::where('customer_id', $customer_id)->first();
            return $account;
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la recuperation du compte de retrait - file:CustomerRepository  : ' . $e->getMessage());
            return false;
        }
    }
    
    public function createAccount($data, $initialBalance = 0.00)
    {
        try {
            //dd($data);
            $account = new Account();
            $account->account_id = $data['account_id'];
            $account->customer_id = $data['customer_id'];
            $account->account_number = $data['account_number'];
            $account->balance = $initialBalance;
            $account->balance_after = $initialBalance;
            $account->balance_before = $initialBalance;
            $account->account_type = $data['account_type'] ?? 'savings';
            $account->status = 'active';
            $account->billing_rate = $data['billing_rate'] ?? '30.00';
            $account->save();
            return $account; // Assume the account creation was successful

        } catch (\Exception $e) {
            // Handle any exceptions that may occur during account creation
            \Log::error('Erreur lors de la création du compte : ' . $e->getMessage());
            return false; // Indicate failure
        }

    }
}