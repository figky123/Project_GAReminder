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
        Schema::create('historireminders', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_reminder');
            $table->unsignedBigInteger('id_penerbangan');
            $table->timestamps();

            // Definisi Foreign Key
            $table->foreign('id_reminder')->references('id')->on('reminders')->onDelete('cascade');
            $table->foreign('id_penerbangan')->references('id')->on('penerbangans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historireminders');
    }
};
