<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenerimaanBarangHeader extends Model
{
    protected $table = 'penerimaan_barang_header';
    protected $primaryKey = 'TrxInPK';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'TrxInNo', 'WhsIdf', 'TrxInSuppIdf', 'TrxInNotes'
    ];

    /**
     * Searchable column
     */
    protected $searchableColumn = [
        'TrxInPK', 'TrxInNo', 'WhsIdf', 'TrxInDate', 'TrxInSuppIdf', 'TrxInNotes', 'created_at'
    ];

    /**
     * Searchable Column View Table
     */
    protected $searchableColumnView = [
        'TrxInPK', 'TrxInNo', 'WhsIdf', 'TrxInDate', 'TrxInSuppIdf', 'TrxInNotes', 'created_at', 'WhsName', 'SupplierName'
    ];

    protected $orderBy = [
        'by' => 'TrxInNo',
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
