<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const STATUS_ACTIVE = 'active';

    const STATUS_CANCELLED = 'cancelled';

    const STATUS_EXPIRED = 'expired';

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_active',
        'plan_id',
        'subscription_start',
        'subscription_end',
        'subscription_status',
        'cancelled_at',
        'renews_at',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'is_active' => 'boolean',
        'subscription_start' => 'datetime',
        'subscription_end' => 'datetime',
        'cancelled_at' => 'datetime',
        'renews_at' => 'datetime',
    ];

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAdmin($query)
    {
        return $query->where('is_admin', true);
    }

    public function isSubscribed(): bool
    {
        return $this->subscription_status === self::STATUS_ACTIVE
            && $this->subscription_end
            && now()->lessThanOrEqualTo($this->subscription_end);
    }

    public function isCancelled(): bool
    {
        return $this->subscription_status === self::STATUS_CANCELLED;
    }

    public function isExpired(): bool
    {
        return $this->subscription_status === self::STATUS_EXPIRED
            || ($this->subscription_end && now()->greaterThan($this->subscription_end));
    }

    public function hasActivePlan(): bool
    {
        return $this->plan_id && $this->subscription_status !== null;
    }

    public function isExpiringSoon(int $days = 7): bool
    {
        if (! $this->subscription_end) {
            return false;
        }

        return now()->diffInDays($this->subscription_end, false) <= $days;
    }

    public function subscriptionStatusLabel(): string
    {
        return match ($this->subscription_status) {
            self::STATUS_ACTIVE => 'Aktif',
            self::STATUS_CANCELLED => 'İptal Edildi',
            self::STATUS_EXPIRED => 'Süresi Doldu',
            default => 'Plan Yok',
        };
    }

    public function subscriptionStatusColor(): string
    {
        return match ($this->subscription_status) {
            self::STATUS_ACTIVE => 'emerald',
            self::STATUS_CANCELLED => 'amber',
            self::STATUS_EXPIRED => 'red',
            default => 'gray',
        };
    }
}
