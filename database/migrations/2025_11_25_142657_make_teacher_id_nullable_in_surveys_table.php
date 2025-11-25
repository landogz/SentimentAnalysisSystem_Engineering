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
        Schema::table('surveys', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['teacher_id']);
        });
        
        Schema::table('surveys', function (Blueprint $table) {
            // Modify the column to be nullable
            $table->unsignedBigInteger('teacher_id')->nullable()->change();
        });
        
        Schema::table('surveys', function (Blueprint $table) {
            // Recreate the foreign key constraint with nullable support
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surveys', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['teacher_id']);
        });
        
        Schema::table('surveys', function (Blueprint $table) {
            // Make it not nullable again
            $table->unsignedBigInteger('teacher_id')->nullable(false)->change();
        });
        
        Schema::table('surveys', function (Blueprint $table) {
            // Recreate the foreign key constraint
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }
};
