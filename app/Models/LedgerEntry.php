<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LedgerEntry extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    // entry_type constants
    const TYPE_PROCESSING_FEE   = 'processing_fee';
    const TYPE_CUSTOMER_CREDIT  = 'customer_credit';
    const TYPE_PLATFORM_REVENUE = 'platform_revenue';

    // account_type constants
    const ACCOUNT_PROCESSING_PARTNER = 'processing_partner';
    const ACCOUNT_CUSTOMER           = 'customer';
    const ACCOUNT_PLATFORM           = 'platform';

    protected $fillable = [
        'id',
        'transaction_id',
        'account_type',
        'account_id',
        'entry_type',
        'amount',
        'description',
        'created_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (LedgerEntry $model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'account_id');
    }
}
