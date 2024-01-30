<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Staudenmeir\LaravelMigrationViews\Facades\Schema;

class CreateViewPenerimaanBarangDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $query = "SELECT pbd.*, p.ProductName, pbh.TrxInNo, pbh.TrxInDate, pbh.TrxInNotes, whs.WhsPK, whs.WhsName, s.SupplierPK, s.SupplierName
        FROM penerimaan_barang_detail pbd
        INNER JOIN products p ON p.ProductPK = pbd.TrxInDProductIdf
        INNER JOIN penerimaan_barang_header pbh ON pbh.TrxInPK = pbd.TrxInIDF
        INNER JOIN warehouses whs ON whs.WhsPK = pbh.WhsIdf
        INNER JOIN suppliers s ON s.SupplierPK = pbh.TrxInSuppIdf
        WHERE s.status = '1' AND whs.status = '1' AND p.status = '1'";

        Schema::createOrReplaceView('view_penerimaan_barang_detail', $query);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropViewIfExists('view_penerimaan_barang_detail');
    }
}
