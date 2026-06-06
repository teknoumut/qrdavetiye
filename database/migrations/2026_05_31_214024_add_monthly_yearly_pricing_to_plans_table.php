<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->decimal('monthly_price', 10, 2)->nullable()->after('price');
            $table->decimal('yearly_price', 10, 2)->nullable()->after('monthly_price');
            $table->string('interval')->default('monthly')->after('yearly_price');
        });

        DB::table('plans')->where('id', 2)->update(['monthly_price' => 49.90, 'yearly_price' => 499.90]);
        DB::table('plans')->where('id', 3)->update(['monthly_price' => 99.90, 'yearly_price' => 999.90]);
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['monthly_price', 'yearly_price', 'interval']);
        });
    }
};
