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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->date('date_of_birth');
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->string('address');
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->date('joining_date');
            $table->text('qualifications');
            $table->unsignedInteger('experience');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->decimal('salary', 10, 2);
            $table->string('qualification_degree')->nullable();
            $table->enum('employment_status', ['Full-time', 'Part-time'])->default('Full-time');
            $table->text('responsibilities')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->foreign('subject_id')->references('id')->on('subjects')->cascadeOnUpdate()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
