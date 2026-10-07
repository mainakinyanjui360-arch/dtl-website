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
        Schema::create('procurement_cards', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('tagline');
            $table->text('description');
            $table->string('image')->nullable();
            $table->json('brands')->nullable(); // array of brand names
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_cards');
    }
};
