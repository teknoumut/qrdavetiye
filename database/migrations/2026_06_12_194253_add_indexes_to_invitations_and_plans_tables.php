<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->index(['is_published', 'is_active', 'slug'], 'idx_invitations_published_active_slug');
            $table->index('event_type');
        });

        Schema::table('plans', function (Blueprint $table) {
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropIndex('idx_invitations_published_active_slug');
            $table->dropIndex(['event_type']);
        });

        Schema::table('plans', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });
    }
};
