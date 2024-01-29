<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Staudenmeir\LaravelMigrationViews\Facades\Schema;

class CreateViewPengeluaranBarangHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $query = "SELECT pbh.*, whs.WhsName, spl.SupplierName
        FROM pengeluaran_barang_header pbh
        INNER JOIN warehouses whs ON whs.WhsPK = pbh.WhsIdf
        INNER JOIN suppliers spl ON spl.SupplierPK = pbh.TrxOutSuppIdf
        WHERE whs.status = '1' AND spl.status = '1'";

        Schema::createOrReplaceView('view_pengeluaran_barang_header', $query);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropViewIfExists('view_pengeluaran_barang_header');
    }
}
