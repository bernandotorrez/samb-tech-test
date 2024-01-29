<?php

namespace App\Services\MySQL;

use App\Models\User;

class UserService extends BaseService
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getByUser(string $user)
    {
        return $this->model->where('status', '1')->where('username', $user)->first();
    }

    public function allActive()
    {
        return $this->model->where([
            'status' => '1',
            'level' => 'User'
        ])->get();
    }

    public function deleteByIP(string $ip)
    {
        return $this->model->where('ip', $ip);
    }

     /**
     * Delete All Active Data (For Import Data Only)
     */
    public function deleteAll()
    {
        return $this->model->where('status', '1')->where('nip', '!=', 'admin')->update(['status' => '0']);
    }

    public function getById($id)
    {
        return $this->model->select((new $this->model)->getSearchableColumn())->where($this->primaryKey, $id)->first();
    }
}
