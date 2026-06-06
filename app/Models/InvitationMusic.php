<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationMusic extends Model
{
    protected $table = 'invitation_music';

    protected $fillable = [
        'invitation_id',
        'title',
        'file_path',
        'embed_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
