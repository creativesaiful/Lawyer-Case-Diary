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
        Schema::create('dates', function (Blueprint $table) {
            $table->id();
            // case id foreign key
            $table->unsignedBigInteger('case_id');
            $table->foreign('case_id')->references('id')->on('case_diaries')->onDelete('cascade');
            $table->date('next_date');
            $table->string('short_order')->nullable();
            $table->text('comments')->nullable();
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            //chamber id foreign key
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
        Schema::dropIfExists('dates');
    }
};
