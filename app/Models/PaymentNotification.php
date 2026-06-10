<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentNotification extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'order_no',
        'interval',
        'amount',
        'status',
        'notes',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public static function generateOrderNo(): string
    {
        $prefix = 'EFT';
        $date = now()->format('ymd');
        $rand = strtoupper(substr(uniqid(), -6));

        return $prefix.$date.$rand;
    }
}
