<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiProcessing extends Model
{
    use HasFactory;
    protected $table = 'api_processing';

    protected $fillable = [
        'name',
        'payment_method',
        'api_key',
        'processing_rate',
        'currency',
        'country',
        'is_active',
    ];

    protected $casts = [
        'processing_rate' => 'decimal:6',
        'is_active' => 'boolean',
    ];
}
