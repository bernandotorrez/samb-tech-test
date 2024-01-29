<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengeluaranBarangHeader extends Model
{
    protected $table = 'pengeluaran_barang_header';
    protected $primaryKey = 'TrxOutPK';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'TrxOutNo', 'WhsIdf', 'TrxOutDate', 'TrxOutSuppIdf', 'TrxOutNotes'
    ];

    /**
     * Searchable column
     */
    protected $searchableColumn = [
        'TrxOutPK', 'TrxOutNo', 'WhsIdf', 'TrxOutDate', 'TrxOutSuppIdf', 'TrxOutNotes', 'created_at'
    ];

    /**
     * Searchable Column View Table
     */
    protected $searchableColumnView = [
        'TrxOutPK', 'TrxOutNo', 'WhsIdf', 'TrxOutDate', 'TrxOutSuppIdf', 'TrxOutNotes', 'created_at', 'WhsName', 'SupplierName'
    ];

    protected $orderBy = [
        'by' => 'TrxOutNo',
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
     * Relation to detail
     */
    public function detail()
    {
        return $this->hasMany(PengeluaranBarangDetail::class, 'TrxOutIDF', 'TrxOutPK');
    }
}
