<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('duration_days')->default(30);
            $table->integer('max_invitations')->default(5);
            $table->integer('max_images_per_invitation')->default(10);
            $table->boolean('music_feature')->default(false);
            $table->boolean('video_feature')->default(false);
            $table->boolean('rsvp_feature')->default(true);
            $table->boolean('qr_download')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
