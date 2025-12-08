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
use App\Http\Controllers\Admin\LayananSuratController;
use App\Http\Controllers\Admin\DetailLayananSuratController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\SkpPegawaiController;
use App\Http\Controllers\Admin\SkpPegawaiDetailController;
use App\Http\Controllers\Admin\Sipd\TahunController;
use App\Http\Controllers\Admin\Sipd\DpaController;


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
    return view('home');
})->name('root.index');
Route::match(['get', 'post'], '/track', [DashboardController::class, 'track'])->name('track');
Route::match(['get', 'post'], '/track-surat', [DashboardController::class, 'trackSurat'])->name('track-surat');

Route::get('/track-detail/{uuid}', [DashboardController::class, 'trackDetail'])->name('track-detail');
Route::get('/track-surat-detail/{uuid}', [DashboardController::class, 'trackDetailSurat'])->name('track-surat-detail');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/sipd', [DashboardController::class, 'sipd'])->name('sipd');
Route::get('/absensi', [DashboardController::class, 'absensi'])->name('absensi');

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
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

    Route::resource('layanan-surat', LayananSuratController::class);
    Route::get('layanan-surat-data', [LayananSuratController::class, 'getData'])->name('layanan-surat.data');
    Route::resource('layanan-surat-detail', DetailLayananSuratController::class);
    Route::get('/layanan-surat-detail-data/{id}', [DetailLayananSuratController::class, 'data'])->name('layanan-surat-detail.data');
    // Route::post('/layanan-surat-detail/store', [DetailLayananSuratController::class, 'store'])->name('layanan-surat-detail.store');
    // Route::get('/layanan-surat-detail/{id}', [DetailLayananSuratController::class, 'show'])->name('layanan-surat-detail.edit');
    // Route::post('/layanan-surat-detail/{id}', [DetailLayananSuratController::class, 'update'])->name('layanan-surat-detail.update');
    // Route::delete('/layanan-surat-detail/{id}', [DetailLayananSuratController::class, 'destroy'])->name('layanan-surat-detail.destroy');

    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/pegawai/data', [PegawaiController::class, 'data'])->name('pegawai.data');
    Route::post('/pegawai/import', [PegawaiController::class, 'import'])->name('pegawai.import');

    Route::get('/skp-pegawai', [SkpPegawaiController::class, 'index'])->name('skp-pegawai.index');
    Route::get('/skp-pegawai/data', [SkpPegawaiController::class, 'data'])->name('skp-pegawai.data');
    Route::post('/skp-pegawai/store', [SkpPegawaiController::class, 'store'])->name('skp-pegawai.store');

    Route::get('/skp-pegawai-detail/{uuid}', [SkpPegawaiDetailController::class, 'index'])->name('skp-pegawai-detail.index');
    Route::get('/skp-pegawai-detail/data', [SkpPegawaiDetailController::class, 'data'])->name('skp-pegawai-detail.data');
    Route::post('/skp-pegawai-detail/import', [SkpPegawaiDetailController::class, 'import'])->name('skp-pegawai-detail.import');
    // SIPD Routes
    Route::prefix('sipd-ri')->group(function () {
    Route::get('/tahun', [TahunController::class, 'index'])->name('sipd.tahun.index');
    Route::get('/tahun/data', [TahunController::class, 'data'])->name('sipd.tahun.data');
    Route::get('/dpa/{jenis}', [DpaController::class, 'index'])->name('sipd.dpa.index');
    Route::post('/dpa/data/{jenis}', [DpaController::class, 'data'])->name('sipd.dpa.data');

    });
    Route::prefix('sippol')->group(function () {
        Route::get('/view-bp22', [DashboardController::class, 'bpduadua'])->name('sippol.view.bp22');
        Route::post('/read-bp22', [DashboardController::class, 'readExcel'])->name('sipd.read.bp22');

    });
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
