<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    protected $table = 'qr_codes';

    protected $fillable = [
        'invitation_id',
        'svg_path',
        'png_path',
        'scan_count',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }

    public function scans()
    {
        return $this->hasMany(QrScan::class);
    }
}
