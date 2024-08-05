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
    {  Schema::create('penerbangans', function (Blueprint $table) {
        $table->id();
        $table->string('nomor_penerbangan');
        $table->string('rute_penerbangan');
        $table->time('jam_penerbangan');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerbangans');
    }
};
