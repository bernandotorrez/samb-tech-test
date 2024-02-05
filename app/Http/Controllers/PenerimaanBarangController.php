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
        $header = $this->penerimaanBarangHeaderService->getByIdView($id);
        $details = $this->penerimaanBarangDetailService->getByForeignKeyView($header->TrxInPK);

        $htmlHeader = '';
        $htmlDetail = '';

        // Header
        $htmlHeader .= '<div class="form-group">
            <h4 class="mb-30 mt-30 text-center">Header</h4>
            <p class="">Nomor Transaksi Pengeluaran Barang</p>
            <input type="text" class="form-control"
                id="TrxOutNo" name="TrxOutNo"
                autocomplete="off"
                placeholder="Contoh : TRX/OUT/001"
                minlength="3" maxlength="100"
                required>
            <span class="text-danger" id="error-TrxOutNo"></span>
        </div>';

        $htmlHeader .= '<div class="form-group">
            <p class="">Tanggal Transaksi</p>
            <input type="text" class="form-control bg-grey-light-1"
                id="TrxOutDate" name="TrxOutDate"
                autocomplete="off"
                minlength="3" maxlength="25"
                value="'.date('d-m-Y', strtotime($header->TrxInDate)).'"
                readonly
                required>
            <span class="text-danger" id="error-TrxOutDate"></span>
        </div>';

        $htmlHeader .= '<div class="form-group">
            <p class="">Warehouse</p>
            <select id="WhsIdf" name="WhsIdf" class="form-control"
                aria-placeholder="Pilih Warehouse"
                placeholder="Pilih Warehouse"
                required>
                <option value="'.$header->WhsIdf.'">'.$header->WhsName.'</option>
                </select>
            <span class="text-danger" id="error-WhsIdf"></span>
        </div>';

        $htmlHeader .= '<div class="form-group">
            <p class="">Supplier</p>
            <select id="TrxOutSuppIdf" name="TrxOutSuppIdf" class="form-control"
                aria-placeholder="Pilih Supplier"
                placeholder="Pilih Supplier"
                required>
                    <option value="'.$header->TrxInSuppIdf.'">'.$header->SupplierName.'</option>
            </select>
            <span class="text-danger" id="error-TrxOutSuppIdf"></span>
        </div>';

        $htmlHeader .= '<div class="form-group">
            <p class="">Catatan Transaksi</p>
            <textarea type="text" class="form-control"
                id="TrxOutNotes" name="TrxOutNotes"
                autocomplete="off"
                placeholder="Contoh : Catatan"
                minlength="3" maxlength="250"
                required>'.$header->TrxInNotes.'</textarea>
            <span class="text-danger" id="error-TrxOutNotes"></span>
        </div>';

        foreach($details as $product) {

            // Detail
            $htmlDetail .= '<div class="form-group">
                <h4 class="mb-30 mt-30 text-center">Detail</h4>
                <p class="">Produk</p>
                <select id="TrxOutDProductIdf" name="TrxOutDProductIdf[]" class="form-control TrxOutDProductIdf"
                    aria-placeholder="Pilih Produk"
                    placeholder="Pilih Produk"
                    required>
                    <option value="'.$product->TrxInDProductIdf.'">'.$product->ProductName.'</option>
                </select>
                <span class="text-danger" id="error-TrxOutDProductIdf"></span>
            </div>';

            $htmlDetail .= '<div class="form-group">
                <p class="">Dus (max = '.$product->TrxInDQtyDus.')</p>
                <input type="number" class="form-control TrxOutDQtyDus"
                    id="TrxOutDQtyDus" name="TrxOutDQtyDus[]"
                    autocomplete="off"
                    minlength="1" maxlength="4"
                    min="0" max="'.$product->TrxInDQtyDus.'"
                    value="0"
                    onkeypress="return onlyNumberKey(event)"
                    onchange="checkQty(this)"
                    >
                <span class="text-danger" id="error-TrxOutDQtyDus"></span>
            </div>';

            $htmlDetail .= '<div class="form-group">
                <p class="">Pieces (max = '.$product->TrxInDQtyPcs.')</p>
                <input type="number" class="form-control TrxOutDQtyPcs"
                    id="TrxOutDQtyPcs" name="TrxOutDQtyPcs[]"
                    autocomplete="off"
                    minlength="1" maxlength="4"
                    min="0" max="'.$product->TrxInDQtyPcs.'"
                    value="0"
                    onkeypress="return onlyNumberKey(event)"
                    onchange="checkQty(this)"
                    >
                <span class="text-danger" id="error-TrxOutDQtyPcs"></span>
            </div>';
        }

        $data = compact('htmlHeader', 'htmlDetail');

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Detail Penerimaan Barang ditemukan',
            'data' => $data
        ], 200);
    }
}
