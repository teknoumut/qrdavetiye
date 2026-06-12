<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('plans')->where('video_feature', true)->update(['cover_video_feature' => true]);
    }

    public function down(): void
    {
        DB::table('plans')->where('video_feature', true)->update(['cover_video_feature' => false]);
    }
};
