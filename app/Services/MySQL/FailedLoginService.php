<?php

namespace App\Services\MySQL;

use App\Models\FailedLogin;

class FailedLoginService extends BaseService
{
    public function __construct(FailedLogin $model)
    {
        parent::__construct($model);
    }

    /**
     * Get by IP Address
     */
    public function getByIP(string $ip)
    {
        return $this->model->where('ip_address', $ip)->orderBy('created_at', 'desc')->get();
    }

    /**
     * Delete by IP
     */
    public function deleteByIP(string $ip)
    {
        return $this->model->where('ip_address', $ip)->delete();
    }
}
