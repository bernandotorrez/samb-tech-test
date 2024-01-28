<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenerimaanBarangDetail extends Model
{
    protected $table = 'penerimaan_barang_detail';
    protected $primaryKey = 'TrxInDPK';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'TrxInIDF', 'TrxInDProductIdf', 'TrxInDQtyDus', 'TrxInDQtyPcs'
    ];

    /**
     * Searchable column
     */
    protected $searchableColumn = [
        'TrxInIDF', 'TrxInDProductIdf', 'TrxInDQtyDus', 'TrxInDQtyPcs', 'created_at'
    ];

    /**
     * Searchable Column View Table
     */
    protected $searchableColumnView = [
        'TrxInIDF', 'TrxInDProductIdf', 'TrxInDQtyDus', 'TrxInDQtyPcs', 'created_at'
    ];

    protected $orderBy = [
        'by' => 'TrxInIDF',
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
}
