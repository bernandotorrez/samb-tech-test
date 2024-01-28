<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Services\MySQL\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->allActive();

        $compact = compact('data');

        return view('pages.user.index', $compact);
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function store(UserRequest $request)
    {
        $validated = $request->validated();

        $username = trim($validated['username']);
        $name = $validated['name'];
        $password = Hash::make(trim($validated['password']));
        $uuid = (string) Str::uuid();

        $checkUser = $this->service->getByUser($username);

        if($checkUser) {
            return response()->json([
                'code' => 200,
                'success' => false,
                'message' => 'Username sudah ada',
                'data' => null
            ], 200);
        } else {
            $insert = $this->service->create([
                'uuid_user' => $uuid,
                'username' => $username,
                'name' => $name,
                'password' => $password,
                'level' => 'User'
            ]);

            if($insert) {
                return response()->json([
                    'code' => 200,
                    'success' => true,
                    'message' => 'Pengguna berhasil di tambah',
                    'data' => null
                ], 200);
            } else {
                return response()->json([
                    'code' => 200,
                    'success' => false,
                    'message' => 'Pengguna gagal di tambah',
                    'data' => null
                ], 200);
            }
        }
    }

    public function edit($id = null)
    {
        $data = $this->service->getById($id);

        $compact = compact('data');

        return view('pages.user.edit', $compact);
    }

    public function update($id = null, UpdateUserRequest $request)
    {
        $validated = $request->validated();

        $name = $validated['name'];

        $update = $this->service->update($id, [
            'name' => $name,
        ]);

        if($update) {
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Pengguna berhasil di ubah',
                'data' => null
            ], 200);
        } else {
            return response()->json([
                'code' => 200,
                'success' => false,
                'message' => 'Pengguna gagal di ubah',
                'data' => null
            ], 200);
        }
    }

    public function delete($id = null)
    {
        $data = $this->service->getById($id);

        if($data->level == 'Admin') {
            return response()->json([
                'code' => 200,
                'success' => false,
                'message' => 'Tidak bisa menghapus User dengan Level Admin',
                'data' => null
            ], 200);
        } else {
            $delete = $this->service->delete($id);

            if($delete) {
                return response()->json([
                    'code' => 200,
                    'success' => true,
                    'message' => 'Sukses Hapus Data',
                    'data' => null
                ], 200);
            } else {
                return response()->json([
                    'code' => 200,
                    'success' => false,
                    'message' => 'Gagal Hapus Data',
                    'data' => null
                ], 200);
            }
        }
    }

    public function editPassword($id = null)
    {
        $data = $this->service->getById($id);

        $compact = compact('data');

        return view('pages.user.edit-password', $compact);
    }

    public function updatePassword($id = null, UpdatePasswordUserRequest $request)
    {
        $validated = $request->validated();

        $password = trim($validated['password']);

        $update = $this->service->update($id, [
            'password' => Hash::make($password),
        ]);

        if($update) {
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Password berhasil di ubah',
                'data' => null
            ], 200);
        } else {
            return response()->json([
                'code' => 200,
                'success' => false,
                'message' => 'Password gagal di ubah',
                'data' => null
            ], 200);
        }
    }
}
