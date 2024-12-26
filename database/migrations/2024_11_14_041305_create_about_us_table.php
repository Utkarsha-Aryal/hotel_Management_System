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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->text('introduction')->nullable();
            $table->string('img_introduction')->nullable();
            $table->string('founder_name')->nullable();
            $table->text('founder_message')->nullable();
            $table->text('founder_image')->nullable();
            $table->string('awards_number')->nullable();
            $table->string('teacher_number')->nullable();
            $table->string('student_number_each_year')->nullable();
            $table->string('scholarship_number')->nullable();
            $table->string('vision')->nullable();
            $table->string('vision_image')->nullable();
            $table->string('mission')->nullable();
            $table->string('mission_image')->nullable();
            $table->string('video_title')->nullable();
            $table->string('video_url')->nullable();
            $table->enum('status', ['Y', 'N'])->default('Y');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
