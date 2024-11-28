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
            $table->foreignId('category_id')->constrained('room_categories','id');
            $table->foreignId('user_id')->nullable();
            $table->integer('order_number');
            $table->integer('max_occupancy'); 
            $table->integer('room_no')->nullable();
            $table->integer('floor_no')->nullable();
            $table->string('room_view')->nullable();
            $table->enum('smoking',['Y','N'])->default('N');
            $table->enum('room_status',['Available','Occupied','Maintenance','Blocked'])->nullable();
            $table->integer('room_size')->nullable();
            $table->enum('status',['Y','N'])->default('Y'); 
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
