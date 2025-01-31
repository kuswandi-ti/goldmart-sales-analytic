<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RangeHargaController;
use App\Http\Controllers\TipeBarangController;
use App\Http\Controllers\SalesPersonController;
use App\Http\Controllers\CustomerVisitController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'login'])->name('login');

/** Auth Routes */
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'handleLogin'])->name('login.post');
Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot_password');
Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot_password.send');
Route::get('reset-password/{token}', [AuthController::class, 'resetPassword'])->name('reset_password');
Route::post('reset-password', [AuthController::class, 'handleResetPassword'])->name('reset_password.send');

Route::group(['middleware' => ['auth_check', 'prevent_back_history']], function () {
    /** Auth Routes */
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    /** Dashboard Routes */
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    /** Profile Routes */
    Route::put('profile-password-update/{id}', [ProfileController::class, 'updatePassword'])->name('profile_password.update');
    Route::resource('profile', ProfileController::class);

    /** User Routes */
    Route::put('user/password-update/{id}', [UserController::class, 'updatePassword'])->name('user.password_update');
    Route::get('user/data', [UserController::class, 'data'])->name('user.data');
    Route::get('user/restore/{user}', [UserController::class, 'restore'])->name('user.restore');
    Route::resource('user', UserController::class);

    /** Role Routes */
    Route::get('role/data', [RoleController::class, 'data'])->name('role.data');
    Route::resource('role', RoleController::class);

    /** Permission Routes */
    Route::get('permission/data', [PermissionController::class, 'data'])->name('permission.data');
    Route::resource('permission', PermissionController::class);

    /** Brand Routes */
    Route::get('brand/data', [BrandController::class, 'data'])->name('brand.data');
    Route::resource('brand', BrandController::class);

    /** Tipe Barang Routes */
    Route::get('tipebarang/data', [TipeBarangController::class, 'data'])->name('tipebarang.data');
    Route::resource('tipebarang', TipeBarangController::class);

    /** Range Harga Routes */
    Route::get('rangeharga/data', [RangeHargaController::class, 'data'])->name('rangeharga.data');
    Route::resource('rangeharga', RangeHargaController::class);

    /** Customer Visit Routes */
    Route::get('customervisit/input', [CustomerVisitController::class, 'input'])->name('customervisit.input');
    Route::get('customervisit/param1', [CustomerVisitController::class, 'param1'])->name('customervisit.param1');
    Route::get('customervisit/param2', [CustomerVisitController::class, 'param2'])->name('customervisit.param2');
    Route::get('customervisit/param3', [CustomerVisitController::class, 'param3'])->name('customervisit.param3');
    Route::get('customervisit/param4', [CustomerVisitController::class, 'param4'])->name('customervisit.param4');
    Route::get('customervisit/{id}/{action}/param1', [CustomerVisitController::class, 'actionParam1'])->name('customervisit.action.param1');
    Route::get('customervisit/{id}/{action}/param2', [CustomerVisitController::class, 'actionParam2'])->name('customervisit.action.param2');
    Route::get('customervisit/{id}/{action}/param3', [CustomerVisitController::class, 'actionParam3'])->name('customervisit.action.param3');
    Route::get('customervisit/{id}/{action}/param4', [CustomerVisitController::class, 'actionParam4'])->name('customervisit.action.param4');
    Route::get('customervisit/data', [CustomerVisitController::class, 'data'])->name('customervisit.data');
    Route::resource('customervisit', CustomerVisitController::class);

    /** Kota Routes */
    Route::get('kotas/data', [KotaController::class, 'data'])->name('kotas.data');
    Route::resource('kotas', KotaController::class);

    /** Store Routes */
    Route::get('store/data', [StoreController::class, 'data'])->name('store.data');
    Route::get('store/restore/{store}', [StoreController::class, 'restore'])->name('store.restore');
    Route::resource('store', StoreController::class);

    /** Sales Person Routes */
    Route::get('salesperson/data', [SalesPersonController::class, 'data'])->name('salesperson.data');
    Route::get('salesperson/restore/{salesperson}', [SalesPersonController::class, 'restore'])->name('salesperson.restore');
    Route::resource('salesperson', SalesPersonController::class);

    /** Laporan Routes */
    Route::get('laporan/salesperperson', [LaporanController::class, 'laporanPenjualanPerPerson'])->name('laporan.penjualanperperson');
    Route::get('laporan/salesperstore', [LaporanController::class, 'laporanPenjualanPerStore'])->name('laporan.penjualanperstore');
    Route::get('laporan/salesallstore', [LaporanController::class, 'laporanPenjualanAllStore'])->name('laporan.penjualanallstore');

    /** Setting Routes */
    Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('general-setting', [SettingController::class, 'generalSettingUpdate'])->name('general_setting.update');
    Route::put('other-setting', [SettingController::class, 'otherSettingUpdate'])->name('other_setting.update');
});

// require __DIR__ . '/auth.php';
