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
        Schema::create('counselors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('specialization');
            $table->text('bio')->nullable();
            $table->integer('years_of_experience')->default(0);
            $table->decimal('hourly_rate', 10, 2);
            $table->string('profile_image')->nullable();
            $table->boolean('is_available')->default(true);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_sessions')->default(0);
            $table->json('certifications')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counselors');
    }
};
