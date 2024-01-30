<?php

namespace App\Services\MySQL;

use App\Models\MasterSupplier;
use Illuminate\Support\Facades\DB;

class MasterSupplierService extends BaseService
{
    protected string $viewPenerimaanHeader = 'view_penerimaan_barang_header';

    public function __construct(MasterSupplier $model)
    {
        parent::__construct($model);
    }

    public function getByPenerimaanHeader()
    {
        $data = DB::table($this->viewPenerimaanHeader)
        ->select(DB::raw('DISTINCT SupplierPK, SupplierName'))
        ->orderBy($this->orderBy['by'], $this->orderBy['order'])
        ->get();

        return $data;
    }
}
