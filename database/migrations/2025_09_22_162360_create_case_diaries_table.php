<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('case_diaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chamber_id');
            $table->string('case_number');
            $table->unsignedBigInteger('court_id');
            $table->string('plaintiff_name');
            $table->string('defendant_name');
            $table->string('client_mobile');
            $table->string('lawyer_side')->comment('Plaintiff / Defendant / Both / Other');
            $table->date('next_date')->nullable();
            $table->text('short_order')->nullable();
            $table->longText('details')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('court_id')->references('id')->on('court_lists')->onDelete('cascade');
            $table->foreign('chamber_id')->references('id')->on('chambers')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_diaries');
    }
};