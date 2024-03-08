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
        Schema::create('user_menu', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('menu_id')->constrained();
            $table->primary(['user_id', 'menu_id']);
            $table->enum('state', ['0', '1'])->default('0');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
