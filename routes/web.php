<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterCustomerController;
use App\Http\Controllers\MasterProductController;
use App\Http\Controllers\MasterSupplierController;
use App\Http\Controllers\MasterWarehouseController;
use App\Http\Controllers\PenerimaanBarangController;
use App\Http\Controllers\PengeluaranBarangController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['frame', 'allowed.methods'])->group(function () {
    Route::middleware(['throttle:ip_address'])->group(function () {
        Route::get('/', [LoginController::class, 'index'])->name('index')->middleware('guest');

        Route::post('/login', [LoginController::class, 'login'])->name('login-action')->middleware('guest');

        Route::get('/login/check-login-block', [LoginController::class, 'checkLoginBlock'])->name('check-login-block')->middleware('guest');

        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

        Route::middleware(['auth'])->group(function () {
            Route::get('/home', [HomeController::class, 'index'])->name('home');

            // User
            Route::controller(UserController::class)->middleware('auth.admin')->group(function () {
                Route::get('/user', 'index')->name('user.index');
                Route::get('/user/create', 'create')->name('user.create');
                Route::post('/user/store', 'store')->name('user.store');
                Route::get('/user/edit/{id}', 'edit')->name('user.edit');
                Route::post('/user/update/{id?}', 'update')->name('user.update');
                Route::get('/user/password/{id?}', 'editPassword')->name('user.edit-password');
                Route::post('/user/password/{id?}', 'updatePassword')->name('user.update-password');
                Route::delete('/user/{id?}', 'delete')->name('user.delete');
            });

            // Master Supplier
            Route::resource('master-supplier', MasterSupplierController::class)->except('show');

            // Master Customer
            Route::resource('master-customer', MasterCustomerController::class)->except('show');

            // Master Product
            Route::resource('master-product', MasterProductController::class)->except('show');

            // Master Warehouse
            Route::resource('master-warehouse', MasterWarehouseController::class)->except('show');

            // Penerimaan Barang
            Route::controller(PenerimaanBarangController::class)->prefix('penerimaan-barang')
            ->name('penerimaan-barang.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/detail/{id}', 'detail')->name('detail');
            });

            // Pengeluaran Barang
            Route::controller(PengeluaranBarangController::class)->prefix('pengeluaran-barang')
            ->name('pengeluaran-barang.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/detail/{id}', 'detail')->name('detail');
            });

            // Artisan need Admin -> use middleware Admina
            Route::prefix('cmd')->middleware('auth.admin')->name('artisan.')->group(function () {
                Route::get('/optimize', function () {
                    Artisan::call('optimize');
                    Artisan::call('route:clear');
                })->name('optimize');

                Route::get('/optimize-clear', function () {
                    Artisan::call('optimize:clear');
                })->name('optimize-clear');

                Route::get('/route-clear', function () {
                    Artisan::call('route:clear');
                })->name('route-clear');

                Route::get('/migrate', function () {
                    Artisan::call('migrate');
                })->name('migrate');

                Route::get('/migrate-fresh', function () {
                    Artisan::call('migrate:fresh');
                })->name('migrate-fresh');

                Route::get('/migrate-rollback', function () {
                    Artisan::call('migrate:rollback');
                })->name('migrate-rollback');
            });
        });
    });

    // Replace 404 with Redirect
    Route::fallback(function () {
        return redirect()->route('home');
    });

});
