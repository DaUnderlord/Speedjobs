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
        Schema::table('users', function (Blueprint $table) {
            $table->string('university')->nullable()->after('email');
            $table->string('field_of_study')->nullable()->after('university');
            $table->integer('graduation_year')->nullable()->after('field_of_study');
            $table->text('skills')->nullable()->after('graduation_year');
            $table->enum('experience_level', ['entry', 'intermediate', 'senior'])->default('entry')->after('skills');
            $table->string('phone')->nullable()->after('experience_level');
            $table->string('location')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['university', 'field_of_study', 'graduation_year', 'skills', 'experience_level', 'phone', 'location']);
        });
    }
};
