<?php

namespace App\Services\MySQL;

use App\Models\PengeluaranBarangDetail;
use Illuminate\Support\Facades\DB;

class PengeluaranBarangDetailService extends BaseService
{
    protected string $viewName = 'view_pengeluaran_barang_detail';

    public function __construct(PengeluaranBarangDetail $model)
    {
        parent::__construct($model);
    }

    public function getByForeignKeyView($id)
    {
        $data = DB::table($this->viewName)
        ->select($this->searchableColumnView)
        ->where('TrxOutIDF', $id)
        ->orderBy($this->orderBy['by'], $this->orderBy['order'])->get();

        return $data;
    }
}
