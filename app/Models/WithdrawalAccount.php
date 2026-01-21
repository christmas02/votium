<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalAccount extends Model
{
    use HasFactory;
    protected $primaryKey = 'withdrawal_account_id';
    public $incrementing = false;
    protected $keyType = 'string';
}
