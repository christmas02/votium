<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $primaryKey = 'transaction_id';
    public $incrementing = false; // si ce n’est pas un int
    protected $keyType = 'string'; // si c’est un UUID
}
