<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKetidakhadiranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ketidakhadiran', function (Blueprint $table) {
            $table->id();
            $table->integer('karyawan_id');
            $table->enum('jenis_ijin',['1','2']);
            $table->text('keterangan');
            $table->date('tanggal_ijin');
            $table->enum('status',['1','2']);
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
        Schema::dropIfExists('ketidakhadiran');
    }
}
