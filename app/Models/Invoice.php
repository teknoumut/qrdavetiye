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
        'refund_status',
        'refund_requested_at',
        'refunded_at',
        'refunded_by',
        'refund_reason',
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
        'refund_requested_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    public function refundApprover()
    {
        return $this->belongsTo(User::class, 'refunded_by');
    }

    public function scopeRefundRequested($query)
    {
        return $query->where('refund_status', 'requested');
    }

    public function scopeRefunded($query)
    {
        return $query->where('refund_status', 'refunded');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
