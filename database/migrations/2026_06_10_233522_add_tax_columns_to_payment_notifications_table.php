<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payment_notifications', function (Blueprint $table) {
            $table->decimal('tax_rate', 5, 2)->nullable()->after('amount');
            $table->decimal('tax_amount', 10, 2)->nullable()->after('tax_rate');
            $table->decimal('subtotal', 10, 2)->nullable()->after('tax_amount');
        });
    }

    public function down(): void
    {
        Schema::table('payment_notifications', function (Blueprint $table) {
            $table->dropColumn(['tax_rate', 'tax_amount', 'subtotal']);
        });
    }
};
