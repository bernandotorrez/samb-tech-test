<?php

namespace App\Services\MySQL;

use App\Models\MasterCustomer;

class MasterCustomerService extends BaseService
{
    public function __construct(MasterCustomer $model)
    {
        parent::__construct($model);
    }
}
