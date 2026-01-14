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

use App\Http\Controllers\Admin\Bast\BastMsNomorBaController;
use App\Http\Controllers\Admin\Bast\BastPengurusbarangController;
use App\Http\Controllers\Admin\Bast\BastSatuanController;
use App\Http\Controllers\Admin\Bast\BastStatusController;
use App\Http\Controllers\Admin\Bast\BastUnitKerjaController;
use App\Http\Controllers\Admin\Bast\BastTransaksiController;
use App\Http\Controllers\Admin\Bast\BastTrsNomorBaController;
use App\Http\Controllers\Admin\Bast\BastTrsBastBarangController;

//sippol
use App\Http\Controllers\Admin\Sippol\SippolPeriodeController;
use App\Http\Controllers\Admin\Sippol\SippolUnitKerjaController;
use App\Http\Controllers\Admin\Sippol\SippolBpDuaDuaController;
use App\Http\Controllers\Admin\Sippol\SippolJenisController;
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
        Route::post('/tahun/store', [TahunController::class, 'store'])->name('sipd.tahun.store');
       
        //dpa
        Route::get('/dpa/{jenis}', [DpaController::class, 'index'])->name('sipd.dpa.index');
        Route::post('/dpa/data/{jenis}', [DpaController::class, 'data'])->name('sipd.dpa.data');
        Route::get('/dpa-create', [DpaController::class, 'create'])->name('sipd.dpa.create');
        Route::post('/dpa-store', [DpaController::class, 'store'])->name('sipd.dpa.store');
        Route::post('/dpa-bersih', [DpaController::class, 'bersih'])->name('sipd.dpa.bersih');
        Route::get('/dpa-rekap-sekolah/{id}', [DpaController::class, 'rekapSekolah'])->name('sipd.dpa.rekap-sekolah');
        Route::get('/dpa-rekap-kode-rekening/{id}', [DpaController::class, 'rekapKodeRekening'])->name('sipd.dpa.rekap-kode-rekening');


    });
    Route::prefix('sippol')->group(function () {
        Route::get('/view-bp22', [DashboardController::class, 'bpduadua'])->name('sippol.view.bp22');
        Route::post('/read-bp22', [DashboardController::class, 'readExcel'])->name('sipd.read.bp22');

        Route::resource('sippol-periodes', SippolPeriodeController::class);
        // Route::resource('sippol-unit-kerjas', SippolUnitKerjaController::class);
        Route::get('/sippol-unit-kerjass/show/{id}', [SippolUnitKerjaController::class, 'show'])->name('sippol-unit-kerjas.show');
        Route::get('/sippol-unit-kerjas/data/{id}', [SippolUnitKerjaController::class, 'data'])->name('sippol-unit-kerjas.data');
        Route::post('/sippol-unit-kerjas/store', [SippolUnitKerjaController::class, 'store'])->name('sippol-unit-kerjas.store');
        Route::get('/sippol-unit-kerjas/edit/{id}', [SippolUnitKerjaController::class, 'edit'])->name('sippol-unit-kerjas.edit');
        Route::delete('/sippol-unit-kerjas/destroy/{id}', [SippolUnitKerjaController::class, 'destroy'])->name('sippol-unit-kerjas.destroy');

        Route::resource('sippol-bp-dua-duas', SippolBpDuaDuaController::class);
        Route::post('/sippol-bp-dua-duas-bersih', [SippolBpDuaDuaController::class, 'bersih'])->name('sippol-bp-dua-duas.bersih');
        Route::get('/sippol-bp-dua-duas-tanggal/{id}/{tanggal}', [SippolBpDuaDuaController::class, 'tanggal'])->name('sippol-bp-dua-duas.tanggal');
        Route::get('/sippol-bp-dua-duas/list/{id}', [SippolBpDuaDuaController::class, 'show'])->name('sippol-bp-dua-duas.list');
        Route::get('/sippol-bp-dua-duas/data/{id}', [SippolBpDuaDuaController::class, 'data'])->name('sippol-bp-dua-duas.data');


        Route::get('/sippol-jenis/data/{id}', [SippolJenisController::class, 'index'])->name('sippol-jenis.show');
        Route::get('/sippol-jenis/rekap/{id}', [SippolJenisController::class, 'rekap'])->name('sippol-jenis.rekap');
        Route::get('/sippol-jenis/hasil/{id}', [SippolJenisController::class, 'hasil'])->name('sippol-jenis.hasil');
        Route::get('/sippol-jenis/kategori/{id}/{kategori}', [SippolJenisController::class, 'kategori'])->name('sippol-jenis.kategori');
        Route::get('/sippol-jenis/final/{id}', [SippolJenisController::class, 'final'])->name('sippol-jenis.final');
        Route::get('/sippol-jenis/sekolah/{id}/{sekolah}', [SippolJenisController::class, 'sekolah'])->name('sippol-jenis.sekolah');


    });
    Route::prefix('sippol')->group(function () {
        Route::resource('bast-ms-nomor-bas', BastMsNomorBaController::class);
        Route::resource('bast-pengurusbarangs', BastPengurusbarangController::class);
        Route::resource('bast-satuans', BastSatuanController::class);
        Route::resource('bast-statuss', BastStatusController::class);
        Route::resource('bast-unit-kerjas', BastUnitKerjaController::class);
        Route::resource('bast-transaksis', BastTransaksiController::class);
        Route::resource('bast-trs-nomor-bas', BastTrsNomorBaController::class);
        Route::get('/download-file/{id}', [BastTransaksiController::class, 'downloadFile'])->name('bast-transaksis-download-file');
        Route::get('/bast-trs-bast-barangs/index/{id}', [BastTrsBastBarangController::class, 'show'])->name('bast-trs-bast-barangs.index');
        Route::get('/bast-trs-bast-barangs/data/{id}', [BastTrsBastBarangController::class, 'data'])->name('bast-trs-bast-barangs.data');
        Route::post('/bast-trs-bast-barangs/store', [BastTrsBastBarangController::class, 'store'])->name('bast-trs-bast-barangs.store');
        Route::get('/bast-trs-bast-barangs/edit/{id}', [BastTrsBastBarangController::class, 'edit'])->name('bast-trs-bast-barangs.edit');
        Route::delete('/bast-trs-bast-barangs/destroy/{id}', [BastTrsBastBarangController::class, 'destroy'])->name('bast-trs-bast-barangs.destroy');
        Route::get('/bast-trs-bast-barangs/show-file/{id}/{letter}', [BastTrsBastBarangController::class, 'showFile'])->name('bast-trs-bast-barangs.showFile');
        Route::get('/bast-trs-bast-barangs/cetak-pdf/{uuid}', [BastTrsBastBarangController::class, 'cetakPdf'])->name('bast-trs-bast-barangs.cetakPdf');
        Route::get('/bast-trs-bast-barangs/cetak-word/{uuid}', [BastTrsBastBarangController::class, 'cetakWord'])->name('bast-trs-bast-barangs.cetakWord');
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
