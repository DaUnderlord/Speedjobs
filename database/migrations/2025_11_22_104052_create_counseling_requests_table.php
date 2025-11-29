<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('counseling_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('request_type'); // career_transition, interview_prep, etc.
            $table->text('message');
            $table->date('preferred_date')->nullable();
            $table->time('preferred_time')->nullable();
            $table->string('status')->default('pending'); // pending, assigned, completed, cancelled
            $table->foreignId('assigned_counselor_id')->nullable()->constrained('counselors')->onDelete('set null');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('counseling_requests');
    }
};
