<?php

namespace App\Services\MySQL;

use App\Models\PenerimaanBarangHeader;
use Illuminate\Support\Facades\DB;

class PenerimaanBarangHeaderService extends BaseService
{
    protected $viewName = 'view_penerimaan_barang_header';

    public function __construct(PenerimaanBarangHeader $model)
    {
        parent::__construct($model);
    }

     /**
     * Check Duplicate Data
     *
     * @param array @where
     * @return Collection
     */
    public function findDuplicate(array $where)
    {
        return $this->model->select($this->primaryKey)->where($where)->count();
    }

    /**
     * Get By ID View
     *
     * @param array @where
     * @return Collection
     */
    public function getByIdView($id)
    {
        return DB::table($this->viewName)
        ->select($this->searchableColumnView)
        ->where($this->getPrimaryKey(), $id)
        ->orderBy($this->orderBy['by'], $this->orderBy['order'])->first();
    }

    public function insertHeaderAndDetail($header, $details)
    {
        $header['TrxInDate'] = date('Y-m-d');
        $insertHeader = $this->model->create($header);

        foreach($details as $detail) {
            $insertHeader->detail()->create($detail);
        }

        return $insertHeader;
    }
}
