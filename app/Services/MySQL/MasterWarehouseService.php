<?php

namespace App\Services\MySQL;

use App\Models\MasterWarehouse;
use Illuminate\Support\Facades\DB;

class MasterWarehouseService extends BaseService
{
    protected string $viewPenerimaanHeader = 'view_penerimaan_barang_header';

    public function __construct(MasterWarehouse $model)
    {
        parent::__construct($model);
    }

    public function getByPenerimaanHeader()
    {
        $data = DB::table($this->viewPenerimaanHeader)
        ->select(DB::raw('DISTINCT WhsPK, WhsName'))
        ->orderBy($this->orderBy['by'], $this->orderBy['order'])
        ->get();

        return $data;
    }
}
