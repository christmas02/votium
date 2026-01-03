<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    use HasFactory;
    protected $primaryKey = 'candidat_id';
    public $incrementing = false;
    protected $keyType = 'string';
}
