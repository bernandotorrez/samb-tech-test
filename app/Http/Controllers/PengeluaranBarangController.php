<?php

namespace App\Http\Controllers;

use App\Services\MySQL\MasterProductService;
use App\Services\MySQL\MasterSupplierService;
use App\Services\MySQL\MasterWarehouseService;
use App\Services\MySQL\PenerimaanBarangHeaderService;
use App\Services\MySQL\PengeluaranBarangDetailService;
use App\Services\MySQL\PengeluaranBarangHeaderService;
use Illuminate\Http\Request;

class PengeluaranBarangController extends Controller
{
    protected PengeluaranBarangHeaderService $pengeluaranBarangHeaderService;
    protected PengeluaranBarangDetailService $pengeluaranBarangDetailService;
    protected PenerimaanBarangHeaderService $penerimaanBarangHeaderService;
    protected MasterWarehouseService $masterWarehouseService;
    protected MasterSupplierService $masterSupplierService;
    protected MasterProductService $masterProductService;
    protected string $viewName = 'view_pengeluaran_barang_header';
    protected string $viewPenerimaanBarang = 'view_penerimaan_barang_header';

    public function __construct(
        PengeluaranBarangHeaderService $pengeluaranBarangHeaderService,
        PengeluaranBarangDetailService $pengeluaranBarangDetailService,
        PenerimaanBarangHeaderService $penerimaanBarangHeaderService,
        MasterWarehouseService $masterWarehouseService,
        MasterSupplierService $masterSupplierService,
        MasterProductService $masterProductService
    ) {
        $this->pengeluaranBarangHeaderService = $pengeluaranBarangHeaderService;
        $this->pengeluaranBarangDetailService = $pengeluaranBarangDetailService;
        $this->penerimaanBarangHeaderService = $penerimaanBarangHeaderService;
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
        $warehouses = $this->masterWarehouseService->getByPenerimaanHeader();
        $suppliers = $this->masterSupplierService->getByPenerimaanHeader();
        $products = $this->masterProductService->getByPenerimaanHeader();

        $penerimaanBarangs = $this->penerimaanBarangHeaderService->allView($this->viewPenerimaanBarang);

        $compact = compact('warehouses', 'suppliers', 'products', 'penerimaanBarangs');

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
