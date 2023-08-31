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
        Schema::table('donations', function (Blueprint $table) {
            $table->text('comment')->nullable()->change();
            $table->text('brCode')->nullable()->change();
            $table->enum('status', ['OPEN', 'PAID'])->default('OPEN')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->text('comment')->change();
            $table->text('brCode')->change();
            $table->enum('status', ['OPEN', 'PAID'])->change();
        });
    }
};
