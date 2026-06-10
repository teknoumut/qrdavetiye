<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    protected $fillable = [
        'invitation_id',
        'name',
        'email',
        'phone',
        'status',
        'guest_count',
        'message',
        'is_confirmed',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }

    public function scopePending($query)
    {
        return $query->where('is_confirmed', false);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('is_confirmed', true);
    }
}
