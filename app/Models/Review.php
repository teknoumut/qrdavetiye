<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'rating',
        'content',
        'is_approved',
        'is_anonymous',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
        'is_anonymous' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }
}
