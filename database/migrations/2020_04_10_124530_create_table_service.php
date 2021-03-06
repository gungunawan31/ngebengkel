<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_service', function (Blueprint $table) {
            $table->string('id_service',100)->nullable();
            $table->primary('id_service');
            $table->string('id')->nullable();
            $table->date('date_book')->nullable();
            $table->string('id_time')->nullable();
            $table->text('complaint')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('plat')->nullable();
            $table->string('jenis_kendaraan')->nullable();
            $table->string('id_mecanic')->nullable();
            $table->string('flag_status')->nullable();
            $table->string('rating')->nullable();
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
        Schema::dropIfExists('table_service');
    }
}
