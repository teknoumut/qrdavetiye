<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('groom_name')->nullable();
            $table->string('bride_name')->nullable();
            $table->dateTime('event_date')->nullable();
            $table->string('event_time')->nullable();
            $table->text('event_address')->nullable();
            $table->string('event_location')->nullable();
            $table->decimal('event_lat', 10, 7)->nullable();
            $table->decimal('event_lng', 10, 7)->nullable();
            $table->text('welcome_message')->nullable();
            $table->text('story')->nullable();
            $table->text('special_note')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('theme')->default('classic');
            $table->string('font_family')->nullable();
            $table->string('primary_color')->default('#d4af37');
            $table->string('secondary_color')->default('#ffffff');
            $table->boolean('has_music')->default(false);
            $table->string('music_file')->nullable();
            $table->string('embed_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_published')->default(false);
            $table->integer('views')->default(0);
            $table->integer('qr_scans')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
