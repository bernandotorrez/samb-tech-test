<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenerimaanBarangDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penerimaan_barang_detail', function (Blueprint $table) {
            $table->id('TrxInDPK');
            $table->bigInteger('TrxInIDF', false, true)->comment('Foreign Key dari table penerimaan barang header');
            $table->bigInteger('TrxInDProductIdf', false, true);
            $table->integer('TrxInDQtyDus', false, true);
            $table->integer('TrxInDQtyPcs', false, true);
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
        Schema::dropIfExists('penerimaan_barang_detail');
    }
}
