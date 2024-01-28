<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'uuid_user';
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'level', 'password', 'status', 'uuid_user'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Searchable column
     */
    protected $searchableColumn = [
        'username', 'name', 'level', 'status', 'uuid_user'
    ];

    /**
     * Searchable Column View Table
     */
    protected $searchableColumnView = [
        'username', 'name', 'level', 'status', 'uuid_user'
    ];

    protected $orderBy = [
        'by' => 'name',
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
