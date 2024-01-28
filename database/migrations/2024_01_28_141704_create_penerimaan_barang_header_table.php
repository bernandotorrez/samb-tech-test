<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenerimaanBarangHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penerimaan_barang_header', function (Blueprint $table) {
            $table->id('TrxInPK');
            $table->string('TrxInNo', 100);
            $table->bigInteger('WhsIdf', false, true);
            $table->date('TrxInDate');
            $table->bigInteger('TrxInSuppIdf', false, true);
            $table->string('TrxInNotes', 250);
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
        Schema::dropIfExists('penerimaan_barang_header');
    }
}
