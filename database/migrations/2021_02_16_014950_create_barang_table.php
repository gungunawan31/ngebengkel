<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->String('id_barang', 100)->nullable();
            $table->primary('id_barang');
            $table->string('nama_barang')->nullable();
            $table->text('deskripsi_barang')->nullable();
            $table->string('harga_barang')->nullable();
            $table->string('stok_barang')->nullable();
            $table->date('tanggal_barang')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
            $table->string('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
