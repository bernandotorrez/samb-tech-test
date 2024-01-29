<?php

namespace App\Http\Controllers;

use App\Services\MySQL\MasterProductService;
use App\Services\MySQL\MasterSupplierService;
use App\Services\MySQL\MasterWarehouseService;
use App\Services\MySQL\PengeluaranBarangDetailService;
use App\Services\MySQL\PengeluaranBarangHeaderService;
use Illuminate\Http\Request;

class PengeluaranBarangController extends Controller
{
    protected PengeluaranBarangHeaderService $pengeluaranBarangHeaderService;
    protected PengeluaranBarangDetailService $pengeluaranBarangDetailService;
    protected MasterWarehouseService $masterWarehouseService;
    protected MasterSupplierService $masterSupplierService;
    protected MasterProductService $masterProductService;
    protected string $viewName = 'view_pengeluaran_barang_header';

    public function __construct(
        PengeluaranBarangHeaderService $pengeluaranBarangHeaderService,
        PengeluaranBarangDetailService $pengeluaranBarangDetailService,
        MasterWarehouseService $masterWarehouseService,
        MasterSupplierService $masterSupplierService,
        MasterProductService $masterProductService
    ) {
        $this->pengeluaranBarangHeaderService = $pengeluaranBarangHeaderService;
        $this->pengeluaranBarangDetailService = $pengeluaranBarangDetailService;
        $this->masterWarehouseService = $masterWarehouseService;
        $this->masterSupplierService = $masterSupplierService;
        $this->masterProductService = $masterProductService;
    }

    public function index()
    {
        $data = $this->pengeluaranBarangHeaderService->allView($this->viewName);

        $compact = compact('data');

        return view('pages.pengeluaran-barang.index', $compact);
    }

    public function detail($id)
    {
        if(!$id) {
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Detail Pengeluaran Barang tidak ditemukan',
                'data' => null
            ], 200);
        }

        $data = $this->pengeluaranBarangDetailService->getByForeignKeyView($id);

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Detail Pengeluaran Barang ditemukan',
            'data' => $data
        ], 200);
    }

    public function create()
    {
        $warehouses = $this->masterWarehouseService->allActive();
        $suppliers = $this->masterSupplierService->allActive();
        $products = $this->masterProductService->allActive();

        $compact = compact('warehouses', 'suppliers', 'products');

        return view('pages.pengeluaran-barang.create', $compact);
    }

    public function store(Request $request)
    {
        $header = $request->post('header');
        $details = $request->post('details');

        $insertHeader = $this->pengeluaranBarangHeaderService->insertHeaderAndDetail($header, $details);

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Pengeluaran Barang Berhasil',
            'data' => null
        ], 200);
    }
}
