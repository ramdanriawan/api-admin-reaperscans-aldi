<?php

use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PopupController;
use App\Http\Controllers\Api\TentangController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('user-premium/update-status', [\App\Http\Controllers\Api\UserPremiumController::class, 'updateStatus']);
Route::get('user-premium/detail-transaksi', [\App\Http\Controllers\Api\UserPremiumController::class, 'detailTransaksi']);
Route::get('user-premium/get-user-premium', [\App\Http\Controllers\Api\UserPremiumController::class, 'getUserPremium']);
Route::get('user-premium/redirect', [\App\Http\Controllers\Api\UserPremiumController::class, 'redirect']);
Route::get('user-premium/request-transaksi', [\App\Http\Controllers\Api\UserPremiumController::class, 'requestTransaksi']);

Route::get('user/model', [UserController::class, 'model']);
Route::post('user/add-foto-profile', [UserController::class, 'addFotoProfile']);
Route::get('user/forgot-password-done', [UserController::class, 'forgotPasswordDone']);
Route::get('user/get-current-user-like', [UserController::class, 'getCurrentUserLike']);
Route::get('user/set-current-user-like', [UserController::class, 'setCurrentUserLike']);
Route::post('user/forgot-password', [UserController::class, 'forgotPassword']);
Route::get('user/login', [UserController::class, 'login']);
Route::post('user/register-manual', [UserController::class, 'registerManual']);
Route::get('user/profile/{user}', [UserController::class, 'profile']);
Route::get('user/verifikasi', [UserController::class, 'verifikasi']);
Route::get('user/check-verifikasi', [UserController::class, 'checkVerifikasi']);
Route::resource('user', UserController::class)->parameters(['user' => 'user']);

Route::resource('popup', PopupController::class)->parameters(['popup' => 'popup']);
Route::resource('notification', NotificationController::class)->parameters(['notification' => 'notification']);

Route::post('komik/add-komik-komentar-balasan', [\App\Http\Controllers\Api\KomikController::class, 'addKomikKomentarBalasan']);
Route::get('komik/add-komik-komentar-balasan-like', [\App\Http\Controllers\Api\KomikController::class, 'addKomikKomentarBalasanLike']);
Route::get('komik/add-komik-komentar-like', [\App\Http\Controllers\Api\KomikController::class, 'addKomikKomentarLike']);
Route::post('komik/add-komik-chapter-komentar-balasan', [\App\Http\Controllers\Api\KomikController::class, 'addKomikChapterKomentarBalasan']);
Route::get('komik/add-komik-chapter-komentar-balasan-like', [\App\Http\Controllers\Api\KomikController::class, 'addKomikChapterKomentarBalasanLike']);
Route::get('komik/add-komik-chapter-komentar-like', [\App\Http\Controllers\Api\KomikController::class, 'addKomikChapterKomentarLike']);
Route::post('komik/add-komentar', [\App\Http\Controllers\Api\KomikController::class, 'addKomentar']);
Route::get('komik/add-to-dilihat', [\App\Http\Controllers\Api\KomikController::class, 'addToDilihat']);
Route::get('komik/add-to-dilike', [\App\Http\Controllers\Api\KomikController::class, 'addToDilike']);
Route::get('komik/remove-bookmark', [\App\Http\Controllers\Api\KomikController::class, 'removeBookmark']);
Route::get('komik/get-slider', [\App\Http\Controllers\Api\KomikController::class, 'getSlider']);
Route::get('komik/get-rekomendasi', [\App\Http\Controllers\Api\KomikController::class, 'getRekomendasi']);
Route::get('komik/get-ranking', [\App\Http\Controllers\Api\KomikController::class, 'getRanking']);
Route::get('komik/get-bookmark', [\App\Http\Controllers\Api\KomikController::class, 'getBookmark']);
Route::get('komik/get-komik', [\App\Http\Controllers\Api\KomikController::class, 'getKomik']);
Route::get('komik/model', [\App\Http\Controllers\Api\KomikController::class, 'model']);
Route::get('komik/search', [\App\Http\Controllers\Api\KomikController::class, 'search']);
Route::resource('komik', \App\Http\Controllers\Api\KomikController::class)->parameters(['komik' => 'komik']);

Route::get('komik-bookmark/add-to-bookmark', [\App\Http\Controllers\Api\KomikBookmarkController::class, 'addToBookmark']);
Route::get('komik-bookmark/remove-from-bookmark', [\App\Http\Controllers\Api\KomikBookmarkController::class, 'removeFromBookmark']);
Route::get('komik-bookmark/check-user-bookmark', [\App\Http\Controllers\Api\KomikBookmarkController::class, 'checkUserBookmark']);
Route::get('komik-bookmark/model', [\App\Http\Controllers\Api\KomikBookmarkController::class, 'model']);
Route::resource('komik-bookmark', \App\Http\Controllers\Api\KomikBookmarkController::class)->parameters(['komik_bookmark' => 'komik_bookmark']);

Route::get('komik-chapter/get-komik-chapter-dilihat', [\App\Http\Controllers\Api\KomikChapterController::class, 'getKomikChapterDilihat']);
Route::get('komik-chapter/remove-komik-chapter-from-dilihat', [\App\Http\Controllers\Api\KomikChapterController::class, 'removeKomikChapterFromDilihat']);
Route::get('komik-chapter/add-komik-chapter-to-dilike', [\App\Http\Controllers\Api\KomikChapterController::class, 'addKomikChapterToDilike']);
Route::get('komik-chapter/add-to-dilihat', [\App\Http\Controllers\Api\KomikChapterController::class, 'addToDilihat']);
Route::get('komik-chapter/check-user-chapter-dilihat', [\App\Http\Controllers\Api\KomikBookmarkController::class, 'checkUserChapterDilihat']);
Route::get('komik-chapter/model', [\App\Http\Controllers\Api\KomikChapterController::class, 'model']);
Route::resource('komik-chapter', \App\Http\Controllers\Api\KomikChapterController::class)->parameters(['komik_chapter' => 'komik_chapter']);

Route::get('komik-komentar/get-komik-komentar-balasan', [\App\Http\Controllers\Api\KomikKomentarController::class, 'getKomikKomentarBalasan']);
Route::get('komik-komentar/model', [\App\Http\Controllers\Api\KomikKomentarController::class, 'model']);
Route::resource('komik-komentar', \App\Http\Controllers\Api\KomikKomentarController::class)->parameters(['komik_komentar' => 'komik_komentar']);

Route::get('komik-tipe/model', [\App\Http\Controllers\Api\KomikTipeController::class, 'model']);
Route::resource('komik-tipe', \App\Http\Controllers\Api\KomikTipeController::class)->parameters(['komik_tipe' => 'komik_tipe']);