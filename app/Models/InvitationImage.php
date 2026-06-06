<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationImage extends Model
{
    protected $fillable = [
        'invitation_id',
        'image_path',
        'caption',
        'order',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
