<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PemohonController;
use App\Http\Controllers\Admin\JenisLayananController;
use App\Http\Controllers\Admin\DetailLayananController;
use App\Http\Controllers\Admin\StatusController;
use App\Http\Controllers\Admin\TrackingController;


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

Route::get('/', function () {
    return view('welcome');
})->name('root.index');
Route::match(['get', 'post'], '/track', [DashboardController::class, 'track'])->name('track');

Route::get('/track-detail/{uuid}', [DashboardController::class, 'trackDetail'])->name('track-detail');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/absensi', [DashboardController::class, 'absensi'])->name('absensi');

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
    Route::get('/pemohon', [PemohonController::class, 'index'])->name('pemohon.index');
    Route::get('/pemohon/data', [PemohonController::class, 'data'])->name('pemohon.data');
    Route::post('/pemohon/store', [PemohonController::class, 'store'])->name('pemohon.store');
    Route::get('/pemohon/{id}', [PemohonController::class, 'edit'])->name('pemohon.edit');
    Route::post('/pemohon/update/{id}', [PemohonController::class, 'update'])->name('pemohon.update');
    Route::delete('/pemohon/delete/{id}', [PemohonController::class, 'destroy'])->name('pemohon.destroy');

    //
    Route::get('/jenis-layanan', [JenisLayananController::class, 'index'])->name('jenis-layanan.index');
    Route::get('/jenis-layanan/data', [JenisLayananController::class, 'data'])->name('jenis-layanan.data');
    Route::post('/jenis-layanan/store', [JenisLayananController::class, 'store'])->name('jenis-layanan.store');
    Route::get('/jenis-layanan/{id}', [JenisLayananController::class, 'edit'])->name('jenis-layanan.edit');
    Route::post('/jenis-layanan/update/{id}', [JenisLayananController::class, 'update'])->name('jenis-layanan.update');
    Route::delete('/jenis-layanan/delete/{id}', [JenisLayananController::class, 'destroy'])->name('jenis-layanan.destroy');

    Route::get('/detail-layanan', [DetailLayananController::class, 'index'])->name('detail-layanan.index');
    Route::get('/detail-layanan/data', [DetailLayananController::class, 'data'])->name('detail-layanan.data');
    Route::post('/detail-layanan/store', [DetailLayananController::class, 'store'])->name('detail-layanan.store');
    Route::get('/detail-layanan/{id}', [DetailLayananController::class, 'edit'])->name('detail-layanan.edit');
    Route::post('/detail-layanan/update/{id}', [DetailLayananController::class, 'update'])->name('detail-layanan.update');
    Route::delete('/detail-layanan/delete/{id}', [DetailLayananController::class, 'destroy'])->name('detail-layanan.destroy');

    Route::get('/status', [StatusController::class, 'index'])->name('status.index');
    Route::get('/status/data', [StatusController::class, 'data'])->name('status.data');
    Route::post('/status/store', [StatusController::class, 'store'])->name('status.store');
    Route::get('/status/{id}', [StatusController::class, 'edit'])->name('status.edit');
    Route::post('/status/update/{id}', [StatusController::class, 'update'])->name('status.update');
    Route::delete('/status/delete/{id}', [StatusController::class, 'destroy'])->name('status.destroy');

    Route::get('/tracking/{id}', [TrackingController::class, 'index'])->name('tracking.data');
    Route::post('/tracking/store', [TrackingController::class, 'store'])->name('tracking.store');
    Route::get('/tracking-show/{id}', [TrackingController::class, 'show'])->name('tracking.edit');
    Route::post('/tracking-update/{id}', [TrackingController::class, 'update'])->name('tracking.update');
    Route::delete('/tracking-delete/{id}', [TrackingController::class, 'destroy'])->name('tracking.destroy');

    Route::get('/dashboard/detail/kecamatan/{kode}', [DashboardController::class, 'detailKec'])->name('dashboard.detail.kecamatan');
    Route::get('/dashboard/detail/kec/{kode}/page/{page}', [DashboardController::class, 'detailKecPage'])->name('dashboard.detail.kecamatan.page');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/reset-photo', [ProfileController::class, 'resetPhoto'])->name('profile.reset-photo');
    Route::get('/tracking', function () {
        return view('user.tracking.index');
    })->name('tracking.index');
    Route::get('/home', [DashboardController::class, 'home'])->name('home');
});

require __DIR__ . '/auth.php';
