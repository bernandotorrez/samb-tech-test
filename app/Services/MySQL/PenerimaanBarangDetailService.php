<?php

namespace App\Services\MySQL;

use App\Models\PenerimaanBarangDetail;
use Illuminate\Support\Facades\DB;

class PenerimaanBarangDetailService extends BaseService
{
    protected string $viewName = 'view_penerimaan_barang_detail';

    public function __construct(PenerimaanBarangDetail $model)
    {
        parent::__construct($model);
    }

    public function getByForeignKeyView($id)
    {
        $data = DB::table($this->viewName)
        ->select($this->searchableColumnView)
        ->where('TrxInIDF', $id)
        ->orderBy($this->orderBy['by'], $this->orderBy['order'])->get();

        return $data;
    }
}
