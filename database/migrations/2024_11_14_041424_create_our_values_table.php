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
        Schema::create('our_values', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('details')->nullable();
            $table->integer('order')->nullable();
            $table->enum('status',['Y','N'])->default('Y');
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('our_values');
    }
};
