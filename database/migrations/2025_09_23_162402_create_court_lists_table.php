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
        Schema::create('court_lists', function (Blueprint $table) {
            $table->id();
            $table->string('court_name');
            $table->string('judge_name')->nullable();
            $table->unsignedBigInteger('chamber_id');
            $table->foreign('chamber_id')->references('id')->on('chambers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('court_lists');
    }
};
