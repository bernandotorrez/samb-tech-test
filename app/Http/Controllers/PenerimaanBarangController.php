<?php

namespace App\Http\Controllers;

use App\Services\MySQL\MasterProductService;
use App\Services\MySQL\MasterSupplierService;
use App\Services\MySQL\MasterWarehouseService;
use App\Services\MySQL\PenerimaanBarangDetailService;
use App\Services\MySQL\PenerimaanBarangHeaderService;
use Illuminate\Http\Request;

class PenerimaanBarangController extends Controller
{
    protected PenerimaanBarangHeaderService $penerimaanBarangHeaderService;
    protected PenerimaanBarangDetailService $penerimaanBarangDetailService;
    protected MasterWarehouseService $masterWarehouseService;
    protected MasterSupplierService $masterSupplierService;
    protected MasterProductService $masterProductService;
    protected string $viewName = 'view_penerimaan_barang_header';

    public function __construct(
        PenerimaanBarangHeaderService $penerimaanBarangHeaderService,
        PenerimaanBarangDetailService $penerimaanBarangDetailService,
        MasterWarehouseService $masterWarehouseService,
        MasterSupplierService $masterSupplierService,
        MasterProductService $masterProductService
    ) {
        $this->penerimaanBarangHeaderService = $penerimaanBarangHeaderService;
        $this->penerimaanBarangDetailService = $penerimaanBarangDetailService;
        $this->masterWarehouseService = $masterWarehouseService;
        $this->masterSupplierService = $masterSupplierService;
        $this->masterProductService = $masterProductService;
    }

    public function index()
    {
        $data = $this->penerimaanBarangHeaderService->allView($this->viewName);

        $compact = compact('data');

        return view('pages.penerimaan-barang.index', $compact);
    }

    public function create()
    {
        $warehouses = $this->masterWarehouseService->allActive();
        $suppliers = $this->masterSupplierService->allActive();
        $products = $this->masterProductService->allActive();

        $compact = compact('warehouses', 'suppliers', 'products');

        return view('pages.penerimaan-barang.create', $compact);
    }

    public function store(Request $request)
    {
        $formHeader = $request->post('formHeader');
        $formHeaderData = $request->post('formHeaderData');
        $formDetail = $request->post('formDetail');

        // print_r($formDetail);
        // echo '<br>';

        foreach($formDetail as $key => $value) {
            echo $value['name'];
            echo $value['value'];
            echo '<br>';
        }

        return response()->json([
            'code' => 409,
            'success' => true,
            'message' => 'Customer berhasil di hapus',
            'data' => null
        ], 409);

        // $insertHeader = $this->penerimaanBarangHeaderService->create([
        //     'TrxInNo' => $formHeader['TrxInNo']
        // ]);
    }
}
