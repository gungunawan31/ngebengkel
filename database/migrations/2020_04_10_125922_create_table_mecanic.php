<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMecanic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_mecanic', function (Blueprint $table) {
            $table->string('id_mecanic')->nullable();
            $table->primary('id_mecanic');
            $table->string('nama_mecanic')->nullable();
            $table->text('alamat_mecanic')->nullable();
            $table->date('tlglahir_mecanic')->nullable();
            $table->string('tempatlahir_mecanic')->nullable();
            $table->string('no_tlpn')->nullable();
            $table->string('email_mecanic')->nullable()->unique();
            $table->string('status_job')->nullable();
            $table->string('status_mecanic')->nullable();
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
        Schema::dropIfExists('table_mecanic');
    }
}
