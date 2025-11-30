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
        Schema::table('reminders', function (Blueprint $table) {
            // Primero eliminar la foreign key constraint
            $table->dropForeign(['course_id']);
            
            // Hacer el campo nullable
            $table->unsignedBigInteger('course_id')->nullable()->change();
            
            // Recrear la foreign key constraint con nullable
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reminders', function (Blueprint $table) {
            // Eliminar la foreign key constraint
            $table->dropForeign(['course_id']);
            
            // Hacer el campo no nullable
            $table->unsignedBigInteger('course_id')->nullable(false)->change();
            
            // Recrear la foreign key constraint sin nullable
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }
};

