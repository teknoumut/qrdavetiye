<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_notifications', function (Blueprint $table) {
            $table->boolean('is_upgrade')->default(false)->after('subtotal');
        });
    }

    public function down(): void
    {
        Schema::table('payment_notifications', function (Blueprint $table) {
            $table->dropColumn('is_upgrade');
        });
    }
};
