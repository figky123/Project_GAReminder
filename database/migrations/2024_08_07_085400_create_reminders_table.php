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
         Schema::create('reminders', function (Blueprint $table) {
             $table->id();
             $table->string('no_hp');
             $table->string('isi_pesan');
             $table->string('ket_pesan');
             $table->date('tgl_berangkat');
             $table->string('gambar_pesan');
             $table->enum('status_tiket', ['Irregularity','OK']);
             $table->timestamps();
         });
     }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
