<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campagne extends Model
{
    use HasFactory;
    protected $primaryKey = 'campagne_id';
    public $incrementing = false;
    protected $keyType = 'string';
}
