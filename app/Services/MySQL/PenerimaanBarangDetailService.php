<?php

namespace App\Services\MySQL;

use App\Models\PenerimaanBarangDetail;

class PenerimaanBarangDetailService extends BaseService
{
    public function __construct(PenerimaanBarangDetail $model)
    {
        parent::__construct($model);
    }
}
