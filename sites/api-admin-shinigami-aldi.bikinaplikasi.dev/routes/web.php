<?php

use App\Http\Controllers\SettingsController;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\KomikController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {

    return redirect('login');
});

Route::post('login_manual', [LoginController::class, 'authenticate'])->name('login_manual');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    Route::get('/dashboard', function () {

        $data['users_baru'] = User::where(User::CREATED_AT, 'like', '%' . Carbon::today()->toDateString() . '%')->get();
        $data['users'] = User::all();

        return view('dashboard', $data);
    })->name('dashboard');

    Route::get('user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('user/{user}/premiumkan', ['App\Http\Controllers\UserController', 'premiumkan'])->name('user.premiumkan');
    Route::post('user/premiumkanStore', ['App\Http\Controllers\UserController', 'premiumkanStore'])->name('user.premiumkan_store');
    Route::get('user/{user}/profile', ['App\Http\Controllers\UserController', 'profile'])->name('user.profile');
    Route::put('user/{user}/profile/update', ['App\Http\Controllers\UserController', 'profileUpdate'])->name('user.profile.update');
    Route::get('user/hapus_semua', ['App\Http\Controllers\UserController', 'hapus_semua'])->name('user.hapus_semua');
    Route::resource('user', 'App\Http\Controllers\UserController')->parameters(['user' => 'user']);
    
    Route::resource('slider', 'App\Http\Controllers\SliderController')->parameters(['slider' => 'slider']);
    Route::resource('rekomendasi', 'App\Http\Controllers\RekomendasiController')->parameters(['rekomendasi' => 'rekomendasi']);
    Route::resource('ranking', 'App\Http\Controllers\RankingController')->parameters(['ranking' => 'ranking']);
    
    Route::get('komik/profile', [KomikController::class, 'profile'])->name('komik.profile');
    Route::get('komik/{komik}/profile', ['App\Http\Controllers\KomikController', 'profile'])->name('komik.profile');
    Route::put('komik/{komik}/profile/update', ['App\Http\Controllers\KomikController', 'profileUpdate'])->name('komik.profile.update');
    Route::get('komik/hapus_semua', ['App\Http\Controllers\KomikController', 'hapus_semua'])->name('komik.hapus_semua');
    Route::resource('komik', 'App\Http\Controllers\KomikController')->parameters(['komik' => 'komik']);
    
    Route::get('popup/profile', [PopupController::class, 'profile'])->name('popup.profile');
    Route::get('popup/{popup}/profile', ['App\Http\Controllers\PopupController', 'profile'])->name('popup.profile');
    Route::get('popup/{popup}/aktifkan', ['App\Http\Controllers\PopupController', 'aktifkan'])->name('popup.aktifkan');
    Route::put('popup/{popup}/profile/update', ['App\Http\Controllers\PopupController', 'profileUpdate'])->name('popup.profile.update');
    Route::get('popup/hapus_semua', ['App\Http\Controllers\PopupController', 'hapus_semua'])->name('popup.hapus_semua');
    Route::resource('popup', 'App\Http\Controllers\PopupController')->parameters(['popup' => 'popup']);

    Route::get('genre/profile', [GenreController::class, 'profile'])->name('genre.profile');
    Route::get('genre/{genre}/profile', ['App\Http\Controllers\GenreController', 'profile'])->name('genre.profile');
    Route::put('genre/{genre}/profile/update', ['App\Http\Controllers\GenreController', 'profileUpdate'])->name('genre.profile.update');
    Route::get('genre/hapus_semua', ['App\Http\Controllers\GenreController', 'hapus_semua'])->name('genre.hapus_semua');
    Route::resource('genre', 'App\Http\Controllers\GenreController')->parameters(['genre' => 'genre']);

    Route::get('tipe/profile', [TipeController::class, 'profile'])->name('tipe.profile');
    Route::get('tipe/{tipe}/profile', ['App\Http\Controllers\TipeController', 'profile'])->name('tipe.profile');
    Route::put('tipe/{tipe}/profile/update', ['App\Http\Controllers\TipeController', 'profileUpdate'])->name('tipe.profile.update');
    Route::get('tipe/hapus_semua', ['App\Http\Controllers\TipeController', 'hapus_semua'])->name('tipe.hapus_semua');
    Route::resource('tipe', 'App\Http\Controllers\TipeController')->parameters(['tipe' => 'tipe']);

    Route::get('pembayaran/profile', [PembayaranController::class, 'profile'])->name('pembayaran.profile');
    Route::get('pembayaran/{pembayaran}/profile', ['App\Http\Controllers\PembayaranController', 'profile'])->name('pembayaran.profile');
    Route::put('pembayaran/{pembayaran}/profile/update', ['App\Http\Controllers\PembayaranController', 'profileUpdate'])->name('pembayaran.profile.update');
    Route::get('pembayaran/hapus_semua', ['App\Http\Controllers\PembayaranController', 'hapus_semua'])->name('pembayaran.hapus_semua');
    Route::resource('pembayaran', 'App\Http\Controllers\PembayaranController')->parameters(['pembayaran' => 'pembayaran']);

    Route::get('chapter/import', [ChapterController::class, 'import'])->name('chapter.import');
    Route::post('chapter/importStore', [ChapterController::class, 'importStore'])->name('chapter.importStore');
    Route::get('chapter/profile', [ChapterController::class, 'profile'])->name('chapter.profile');
    Route::get('chapter/{chapter}/profile', ['App\Http\Controllers\ChapterController', 'profile'])->name('chapter.profile');
    Route::put('chapter/{chapter}/profile/update', ['App\Http\Controllers\ChapterController', 'profileUpdate'])->name('chapter.profile.update');
    Route::get('chapter/hapus_semua', ['App\Http\Controllers\ChapterController', 'hapus_semua'])->name('chapter.hapus_semua');
    Route::resource('chapter', 'App\Http\Controllers\ChapterController')->parameters(['chapter' => 'chapter']);

    Route::post('ckeditor/upload', ['App\Http\Controllers\CKEditorController', 'upload']);
    Route::get('tentang', [\App\Http\Controllers\TentangController::class, 'index'])->name('tentang.index');

    Route::resource('settings', SettingsController::class)->parameters(['video_kategori' => 'video_kategori']);
    
    Route::resource('qrcode', QrCodeController::class)->parameters(['qrcode' => 'qrcode']);
});
