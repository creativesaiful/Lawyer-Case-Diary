<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile')->unique()->after('name');
            $table->enum('role', ['admin', 'lawyer', 'staff'])->default('staff')->after('password');
            $table->unsignedBigInteger('chamber_id')->nullable()->after('role');
            $table->string('bar_number')->nullable()->after('chamber_id');
            $table->boolean('approved')->default(false)->after('bar_number');
           
            
            $table->foreign('chamber_id')->references('id')->on('chambers')->onDelete('set null');
            
            // Remove email field
            $table->dropColumn('email');
            $table->dropColumn('email_verified_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['chamber_id']);
            $table->dropColumn(['mobile', 'role', 'chamber_id', 'bar_number', 'approved']);
            
            // Add email field back
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
        });
    }
};