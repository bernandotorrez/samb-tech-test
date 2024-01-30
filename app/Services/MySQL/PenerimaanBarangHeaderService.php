<?php

namespace App\Services\MySQL;

use App\Models\PenerimaanBarangHeader;

class PenerimaanBarangHeaderService extends BaseService
{
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
