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
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('tax_rate', 5, 2)->default(0)->after('amount');
            $table->decimal('tax_amount', 10, 2)->default(0)->after('tax_rate');
            $table->string('billing_name', 100)->nullable()->after('tax_amount');
            $table->text('billing_address')->nullable()->after('billing_name');
            $table->string('tax_number', 20)->nullable()->after('billing_address');
            $table->string('tax_office', 100)->nullable()->after('tax_number');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['tax_rate', 'tax_amount', 'billing_name', 'billing_address', 'tax_number', 'tax_office']);
        });
    }
};
