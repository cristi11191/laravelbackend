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
        if (!Schema::hasTable('students')) {
            Schema::create('students', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('full_name');
                $table->string('student_number');
                $table->string('email')->nullable();
                $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
                $table->foreignId('series_id')->constrained('series')->onDelete('cascade');
                $table->integer('year');
                $table->integer('semester');
                $table->foreignId('faculty_id')->constrained('faculties')->onDelete('cascade');
                $table->foreignId('speciality_id')->constrained('specialities')->onDelete('cascade');
                $table->date('date_of_birth')->nullable();
                $table->string('birth_place')->nullable();
                $table->string('address')->nullable();
                $table->string('city')->nullable();
                $table->string('phone')->nullable();
                $table->boolean('status')->default(0);
                $table->timestamps();
            });
        };
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
