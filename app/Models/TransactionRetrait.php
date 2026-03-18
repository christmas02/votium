<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionRetrait extends Model
{
    use HasFactory;
    protected $table = 'transactions_retrait';
    protected $primaryKey = 'transactions_retrait_id';
    public $incrementing = false;
    protected $keyType = 'string';
}
