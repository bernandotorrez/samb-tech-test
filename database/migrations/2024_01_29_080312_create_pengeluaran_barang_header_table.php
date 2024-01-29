<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengeluaranBarangHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluaran_barang_header', function (Blueprint $table) {
            $table->id('TrxOutPK');
            $table->string('TrxOutNo', 100);
            $table->bigInteger('WhsIdf', false, true);
            $table->date('TrxOutDate');
            $table->bigInteger('TrxOutSuppIdf', false, true);
            $table->string('TrxOutNotes', 250);
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
        Schema::dropIfExists('pengeluaran_barang_header');
    }
}
