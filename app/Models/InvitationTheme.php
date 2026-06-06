<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationTheme extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail',
        'primary_color',
        'secondary_color',
        'font_family',
        'blade_template',
        'is_active',
        'is_premium',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_premium' => 'boolean',
    ];
}
