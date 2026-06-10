<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'invoice_no',
        'interval',
        'amount',
        'tax_rate',
        'tax_amount',
        'status',
        'gateway',
        'transaction_id',
        'billing_name',
        'billing_address',
        'tax_number',
        'tax_office',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
