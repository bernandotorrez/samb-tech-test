<?php

namespace App\Http\Controllers;

use App\Http\Requests\MasterProductRequest;
use App\Services\MySQL\MasterProductService;
use Illuminate\Http\Request;

class MasterProductController extends Controller
{

    protected MasterProductService $service;

    public function __construct(MasterProductService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->service->allActive();

        $compact = compact('data');

        return view('pages.master-product.index', $compact);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.master-product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterProductRequest $request)
    {
        $validated = $request->validated();
        $productName = trim($validated['ProductName']);

        $data = ['ProductName' => $productName];
    
        $check = $this->service->findDuplicate($data);

        if($check) {
            return response()->json([
                'code' => 409,
                'success' => false,
                'message' => 'Product sudah ada',
                'data' => null
            ], 409);
        }

        $insert = $this->service->create($data);

        if($insert) {
            return response()->json([
                'code' => 201,
                'success' => true,
                'message' => 'Product berhasil di tambah',
                'data' => $data
            ], 201);
        } else {
            return response()->json([
                'code' => 200,
                'success' => false,
                'message' => 'Product gagal di tambah',
                'data' => null
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$id) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Product tidak ditemukan',
                'data' => null
            ], 404);
        }

        $data = $this->service->getById(base64_decode($id));
        
        $compact = compact('data');

        return view('pages.master-product.edit', $compact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MasterProductRequest $request, $id)
    {
        if(!$id) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Product tidak ditemukan',
                'data' => null
            ], 404);
        }

        $id = base64_decode($id);

        $validated = $request->validated();
        $productName = trim($validated['ProductName']);

        $data = ['ProductName' => $productName];
    
        $check = $this->service->findDuplicateEdit($id, $data);

        if($check) {
            return response()->json([
                'code' => 409,
                'success' => false,
                'message' => 'Product sudah ada',
                'data' => null
            ], 409);
        }

        $update = $this->service->update($id, $data);

        if($update) {
            return response()->json([
                'code' => 201,
                'success' => true,
                'message' => 'Product berhasil di ubah',
                'data' => $data
            ], 201);
        } else {
            return response()->json([
                'code' => 200,
                'success' => false,
                'message' => 'Product gagal di ubah',
                'data' => null
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$id) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Product tidak ditemukan',
                'data' => null
            ], 404);
        }

        $id = base64_decode($id);

        $delete = $this->service->delete($id);

        if($delete) {
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Product berhasil di hapus',
                'data' => null
            ], 200);
        } else {
            return response()->json([
                'code' => 200,
                'success' => false,
                'message' => 'Product gagal di hapus',
                'data' => null
            ], 200);
        }
    }
}
