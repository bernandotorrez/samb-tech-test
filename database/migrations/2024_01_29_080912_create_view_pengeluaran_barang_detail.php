<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Staudenmeir\LaravelMigrationViews\Facades\Schema;

class CreateViewPengeluaranBarangDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $query = "SELECT pbd.*, p.ProductName, pbh.TrxOutNo, pbh.TrxOutDate, pbh.TrxOutNotes, whs.WhsName, s.SupplierName
        FROM pengeluaran_barang_detail pbd
        INNER JOIN products p ON p.ProductPK = pbd.TrxOutDProductIdf
        INNER JOIN pengeluaran_barang_header pbh ON pbh.TrxOutPK = pbd.TrxOutIDF
        INNER JOIN warehouses whs ON whs.WhsPK = pbh.WhsIdf
        INNER JOIN suppliers s ON s.SupplierPK = pbh.TrxOutSuppIdf";

        Schema::createOrReplaceView('view_pengeluaran_barang_detail', $query);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropViewIfExists('view_pengeluaran_barang_detail');
    }
}
