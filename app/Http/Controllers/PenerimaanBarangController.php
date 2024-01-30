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
        $header = $request->post('header');
        $details = $request->post('details');

        $where = ['TrxInNo' => $header['TrxInNo']];

        $check = $this->penerimaanBarangHeaderService->findDuplicate($where);

        if($check) {
            return response()->json([
                'code' => 409,
                'success' => true,
                'message' => 'Nomor Transaksi Penerimaan Barang sudah ada',
                'data' => null
            ], 409);
        }

        $insertHeader = $this->penerimaanBarangHeaderService->insertHeaderAndDetail($header, $details);

        if($insertHeader) {
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Penerimaan Barang Berhasil',
                'data' => null
            ], 200);
        } else {
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Penerimaan Barang Gagal',
                'data' => null
            ], 200);
        }
    }

    public function detail($id)
    {
        if(!$id) {
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Detail Penerimaan Barang tidak ditemukan',
                'data' => null
            ], 200);
        }

        $data = $this->penerimaanBarangDetailService->getByForeignKeyView($id);

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Detail Penerimaan Barang ditemukan',
            'data' => $data
        ], 200);
    }

    public function headerDetail($id)
    {
        $headers = $this->penerimaanBarangHeaderService->getById($id);
        $details = $this->penerimaanBarangDetailService->getByForeignKeyView($headers->TrxInPK);

        $html = '<div class="form-group">
            <h4 class="mb-30 mt-30 text-center">Detail</h4>
            <p class="">Produk</p>

                @foreach ($products as $product)
                    <option value="{{ $product->ProductPK }}">{{ $product->ProductName }}</option>
                @endforeach
            ';

        foreach($details as $product) {
            $html .= "<option value='$product->TrxInDProductIdf'>$product->ProductName</option>";
        }

        $html .= '<select id="TrxOutDProductIdf" name="TrxOutDProductIdf[]" class="form-control TrxOutDProductIdf"
        aria-placeholder="Pilih Produk"
        placeholder="Pilih Produk"
        required>
        <option value="">- Pilih Produk -</option>';

        $html .= '</select>
            <span class="text-danger" id="error-TrxOutDProductIdf"></span>
        </div>';

        $data = compact('headers', 'details', 'html');

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Detail Penerimaan Barang ditemukan',
            'data' => $data
        ], 200);
    }
}
