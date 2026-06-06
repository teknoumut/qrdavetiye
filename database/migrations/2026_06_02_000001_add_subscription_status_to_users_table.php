<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('subscription_status')->nullable()->after('subscription_end')->comment('active, cancelled, expired');
            $table->timestamp('cancelled_at')->nullable()->after('subscription_status');
            $table->timestamp('renews_at')->nullable()->after('cancelled_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['subscription_status', 'cancelled_at', 'renews_at']);
        });
    }
};
