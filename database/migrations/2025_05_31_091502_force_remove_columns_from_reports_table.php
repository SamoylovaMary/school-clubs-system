<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            // Явная проверка на существование столбцов
            if (Schema::hasColumn('reports', 'students_count')) {
                $table->dropColumn('students_count');
            }
            if (Schema::hasColumn('reports', 'sports')) {
                $table->dropColumn('sports');
            }
            if (Schema::hasColumn('reports', 'events')) {
                $table->dropColumn('events');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            //
        });
    }
};
