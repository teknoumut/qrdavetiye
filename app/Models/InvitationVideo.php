<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationVideo extends Model
{
    protected $fillable = [
        'invitation_id',
        'url',
        'file_path',
        'type',
        'caption',
        'order',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
