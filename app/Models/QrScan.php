<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrScan extends Model
{
    protected $table = 'qr_scans';

    protected $fillable = [
        'qr_code_id',
        'ip_address',
        'user_agent',
    ];

    public function qrCode()
    {
        return $this->belongsTo(QrCode::class);
    }
}
