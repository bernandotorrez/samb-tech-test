<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengeluaranBarangDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluaran_barang_detail', function (Blueprint $table) {
            $table->id('TrxOutDPK');
            $table->bigInteger('TrxOutIDF', false, true)->comment('Foreign Key dari table penerimaan barang header');
            $table->bigInteger('TrxOutDProductIdf', false, true);
            $table->integer('TrxOutDQtyDus', false, true);
            $table->integer('TrxOutDQtyPcs', false, true);
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
        Schema::dropIfExists('pengeluaran_barang_detail');
    }
}
