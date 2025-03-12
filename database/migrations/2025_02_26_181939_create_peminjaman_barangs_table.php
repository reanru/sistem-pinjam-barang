<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman_barang', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('barang_id');
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->string('no_hp');
            $table->date('mulai');
            $table->date('selesai');
            $table->text('deskripsi')->nullable();
            $table->enum('status',['dibatalkan','sementara','selesai'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peminjaman_barangs');
    }
};
