<?php

namespace App\Services\MySQL;

use App\Models\MasterProduct;

class MasterProductService extends BaseService
{
    public function __construct(MasterProduct $model)
    {
        parent::__construct($model);
    }
}
