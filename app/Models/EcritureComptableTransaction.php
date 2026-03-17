<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcritureComptableTransaction extends Model
{
    use HasFactory;
    protected $table = 'ecriture_comptable_transactions';
    protected $primaryKey = 'transaction_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'transaction_id',
        'ecriture_comptable_id',
        'amount',
        'description',
        'transaction_date',
    ];
}
