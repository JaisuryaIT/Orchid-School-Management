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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('class_name')->unique();
            $table->unsignedInteger('grade_level')->default(1);
            $table->string('section')->nullable();
            $table->unsignedBigInteger('teacher_id')->unique()->nullable();
            $table->unsignedBigInteger('academic_year_id');
            $table->unsignedInteger('total_students')->nullable();
            $table->timestamps();
            $table->foreign('teacher_id')->references('id')->on('teachers')->cascadeOnUpdate()->onDelete('set null');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
