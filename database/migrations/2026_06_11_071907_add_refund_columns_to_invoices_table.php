<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('refund_status')->nullable()->after('status');
            $table->timestamp('refund_requested_at')->nullable()->after('refund_status');
            $table->timestamp('refunded_at')->nullable()->after('refund_requested_at');
            $table->foreignId('refunded_by')->nullable()->constrained('users')->after('refunded_at');
            $table->text('refund_reason')->nullable()->after('refunded_by');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['refunded_by']);
            $table->dropColumn(['refund_status', 'refund_requested_at', 'refunded_at', 'refunded_by', 'refund_reason']);
        });
    }
};
