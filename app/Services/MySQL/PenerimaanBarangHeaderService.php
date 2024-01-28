<?php

namespace App\Services\MySQL;

use App\Models\PenerimaanBarangHeader;

class PenerimaanBarangHeaderService extends BaseService
{
    public function __construct(PenerimaanBarangHeader $model)
    {
        parent::__construct($model);
    }
}
