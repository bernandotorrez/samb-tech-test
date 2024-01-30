<?php

namespace App\Services\MySQL;

use App\Models\MasterProduct;
use Illuminate\Support\Facades\DB;

class MasterProductService extends BaseService
{
    protected string $viewPenerimaanDetail = 'view_penerimaan_barang_detail';

    public function __construct(MasterProduct $model)
    {
        parent::__construct($model);
    }

    public function getByPenerimaanHeader()
    {
        $data = DB::table($this->viewPenerimaanDetail)
        ->select(DB::raw('DISTINCT TrxInDProductIdf, ProductName'))
        ->orderBy($this->orderBy['by'], $this->orderBy['order'])
        ->get();

        return $data;
    }
}
