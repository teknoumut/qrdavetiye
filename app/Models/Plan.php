<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'monthly_price',
        'yearly_price',
        'interval',
        'max_invitations',
        'max_images_per_invitation',
        'music_feature',
        'video_feature',
        'rsvp_feature',
        'qr_download',
        'is_active',
    ];

    protected $casts = [
        'monthly_price' => 'decimal:2',
        'yearly_price' => 'decimal:2',
        'music_feature' => 'boolean',
        'video_feature' => 'boolean',
        'rsvp_feature' => 'boolean',
        'qr_download' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
