<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengeluaranBarangDetail extends Model
{
    protected $table = 'pengeluaran_barang_detail';
    protected $primaryKey = 'TrxOutDPK';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'TrxOutIDF', 'TrxOutDProductIdf', 'TrxOutDQtyDus', 'TrxOutDQtyPcs'
    ];

    /**
     * Searchable column
     */
    protected $searchableColumn = [
        'TrxOutIDF', 'TrxOutDProductIdf', 'TrxOutDQtyDus', 'TrxOutDQtyPcs', 'created_at'
    ];

    /**
     * Searchable Column View Table
     */
    protected $searchableColumnView = [
        'TrxOutDPK', 'TrxOutIDF', 'TrxOutDProductIdf', 'TrxOutDQtyDus', 'TrxOutDQtyPcs', 'created_at',
        'ProductName', 'TrxOutNo', 'TrxOutDate', 'TrxOutNotes', 'WhsName', 'SupplierName'
    ];

    protected $orderBy = [
        'by' => 'TrxOutIDF',
        'order' => 'asc'
    ];

    /**
     * Get Searchable Column (table)
     *
     * @return array
     */
    public function getSearchableColumn()
    {
        return $this->searchableColumn;
    }

    /**
     * Get Searchable Column (if use View)
     *
     * @return array
     */
    public function getSearchableColumnView()
    {
        return $this->searchableColumnView;
    }

    /**
     * Get Order By
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * Relation to header
     */
    public function header()
    {
        return $this->hasOne(PengeluaranBarangHeader::class, 'TrxOutPK', 'TrxOutIDF');
    }
}
