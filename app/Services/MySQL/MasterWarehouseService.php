<?php

namespace App\Services\MySQL;

use App\Models\MasterWarehouse;

class MasterWarehouseService extends BaseService
{
    public function __construct(MasterWarehouse $model)
    {
        parent::__construct($model);
    }
}
