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
        Schema::create('our_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description'); 
            $table->text('feature_image')->nullable();
            $table->integer('order_number');
            $table->integer('max_occupancy'); 
            $table->foreignId('category_id')->constrained('room_categories','id');
            $table->string('room_no');
            $table->enum('status',['Y','N'])->default('Y');
            $table->enum('wifi', ['Y', 'N'])->default('N');
            $table->enum('AC', ['Y', 'N'])->default('N');
            $table->enum('TV', ['Y', 'N'])->default('N');
            $table->enum('minibar', ['Y', 'N'])->default('N');
            $table->enum('room_service', ['Y', 'N'])->default('N'); 
            $table->enum('private_bathroom', ['Y', 'N'])->default('N'); 
            $table->enum('balcony', ['Y', 'N'])->default('N');
            $table->enum('swimming_pool', ['Y', 'N'])->default('N');
            $table->enum('smoking_allowed', ['Y', 'N'])->default('N');
            $table->enum('pet_friendly', ['Y', 'N'])->default('N');
            $table->enum('laundry_service', ['Y', 'N'])->default('N'); 
            $table->enum('booked', ['Y', 'N'])->default('N');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('our_rooms');
    }
};
