<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('counselor_bookings', function (Blueprint $table) {
            $table->foreignId('counseling_request_id')->nullable()->after('counselor_id')->constrained('counseling_requests')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('counselor_bookings', function (Blueprint $table) {
            $table->dropForeign(['counseling_request_id']);
            $table->dropColumn('counseling_request_id');
        });
    }
};
