<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE invitation_videos MODIFY url VARCHAR(255) NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE invitation_videos MODIFY url VARCHAR(255) NOT NULL');
    }
};
