<?php

namespace App\Services\MySQL;

use App\Models\PengeluaranBarangHeader;

class PengeluaranBarangHeaderService extends BaseService
{
    public function __construct(PengeluaranBarangHeader $model)
    {
        parent::__construct($model);
    }

    public function insertHeaderAndDetail($header, $details)
    {
        $header['TrxOutDate'] = date('Y-m-d');
        $insertHeader = $this->model->create($header);

        foreach($details as $detail) {
            $insertHeader->detail()->create($detail);
        }

        return $insertHeader;
    }
}
