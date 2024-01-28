<?php

namespace App\Services\MySQL;

use App\Models\MasterSupplier;

class MasterSupplierService extends BaseService
{
    public function __construct(MasterSupplier $model)
    {
        parent::__construct($model);
    }
}
