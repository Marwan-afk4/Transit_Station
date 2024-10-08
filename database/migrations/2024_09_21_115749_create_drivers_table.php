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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parking_id')->Notnull()->constrained()->onDelete('cascade');
            $table->string('name')->Notnull();
            $table->string('email')->unique()->Notnull();
            $table->string('phone')->unique()->Notnull();
            $table->string('password')->Notnull();
            $table->string('image')->Notnull();
            $table->integer('salary')->Notnull();
            $table->string('pick_up_location')->Notnull();
            $table->integer('cars_per_mounth')->Notnull();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
