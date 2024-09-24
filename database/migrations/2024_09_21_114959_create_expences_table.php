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
        Schema::create('expences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_expence_id')->Notnull()->constrained()->onDelete('cascade');
            $table->float('expence_amount')->Notnull();
            $table->date('date')->Notnull();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expences');
    }
};
