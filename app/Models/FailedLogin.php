<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FailedLogin extends Model
{
    protected $table = 'failed_login';
    protected $primaryKey = 'id_failed_login';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'ip_address'
    ];

    /**
     * Searchable column
     */
    protected $searchableColumn = [
        'id_failed_login', 'username', 'ip_address'
    ];

    /**
     * Searchable Column View Table
     */
    protected $searchableColumnView = [
        'id_failed_login', 'username', 'ip_address'
    ];

    protected $orderBy = [
        'by' => 'username',
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
