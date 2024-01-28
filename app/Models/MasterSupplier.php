<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterSupplier extends Model
{
    protected $table = 'suppliers';
    protected $primaryKey = 'SupplierPK';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'SupplierName'
    ];

    /**
     * Searchable column
     */
    protected $searchableColumn = [
        'SupplierPK', 'SupplierName', 'created_at'
    ];

    /**
     * Searchable Column View Table
     */
    protected $searchableColumnView = [
        'SupplierPK', 'SupplierName', 'created_at'
    ];

    protected $orderBy = [
        'by' => 'SupplierName',
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
