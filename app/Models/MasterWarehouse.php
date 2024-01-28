<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterWarehouse extends Model
{
    protected $table = 'warehouses';
    protected $primaryKey = 'WhsPK';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'WhsName'
    ];

    /**
     * Searchable column
     */
    protected $searchableColumn = [
        'WhsPK', 'WhsName', 'created_at'
    ];

    /**
     * Searchable Column View Table
     */
    protected $searchableColumnView = [
        'WhsPK', 'WhsName', 'created_at'
    ];

    protected $orderBy = [
        'by' => 'WhsName',
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
