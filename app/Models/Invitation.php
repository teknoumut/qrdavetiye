<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invitation extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'title',
        'slug',
        'event_type',
        'short_link',
        'groom_name',
        'groom_father',
        'groom_mother',
        'bride_name',
        'bride_father',
        'bride_mother',
        'event_date',
        'event_time',
        'event_address',
        'event_location',
        'event_lat',
        'event_lng',
        'welcome_message',
        'story',
        'special_note',
        'cover_image',
        'theme',
        'font_family',
        'primary_color',
        'secondary_color',
        'envelope_animation',
        'envelope_pattern',
        'custom_pattern',
        'envelope_text_color',
        'corner_decoration',
        'has_music',
        'music_file',
        'embed_url',
        'is_active',
        'is_published',
        'views',
        'qr_scans',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'has_music' => 'boolean',
        'is_active' => 'boolean',
        'is_published' => 'boolean',
        'event_lat' => 'decimal:7',
        'event_lng' => 'decimal:7',
    ];

    protected static function booted(): void
    {
        static::creating(function (Invitation $invitation) {
            if (empty($invitation->slug)) {
                $invitation->slug = Str::slug($invitation->title).'-'.Str::random(6);
            }
        });
    }

    public function setGroomNameAttribute($value)
    {
        $this->attributes['groom_name'] = $value ? ucwords(trim($value)) : null;
    }

    public function setBrideNameAttribute($value)
    {
        $this->attributes['bride_name'] = $value ? ucwords(trim($value)) : null;
    }

    public function setGroomFatherAttribute($value)
    {
        $this->attributes['groom_father'] = $value ? ucwords(trim($value)) : null;
    }

    public function setGroomMotherAttribute($value)
    {
        $this->attributes['groom_mother'] = $value ? ucwords(trim($value)) : null;
    }

    public function setBrideFatherAttribute($value)
    {
        $this->attributes['bride_father'] = $value ? ucwords(trim($value)) : null;
    }

    public function setBrideMotherAttribute($value)
    {
        $this->attributes['bride_mother'] = $value ? ucwords(trim($value)) : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function images()
    {
        return $this->hasMany(InvitationImage::class);
    }

    public function videos()
    {
        return $this->hasMany(InvitationVideo::class);
    }

    public function music()
    {
        return $this->hasMany(InvitationMusic::class);
    }

    public function qrCode()
    {
        return $this->hasOne(QrCode::class);
    }

    public function rsvps()
    {
        return $this->hasMany(Rsvp::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->where('is_active', true);
    }

    public function scopeOwnedBy($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }
}
