<?php

use App\Http\Controllers\api\BagianController;
use App\Http\Controllers\api\LaporanController;
use App\Http\Controllers\api\SpesifikasiController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [UserController::class, 'login'])->name('user.login');
Route::put('/user/{id}', [UserController::class, 'update']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show']);

Route::get('/spesifikasis', [SpesifikasiController::class, 'index']);
Route::get('/bagian', [BagianController::class, 'index']);

Route::post('/penerimaan', [LaporanController::class, 'penerimaan']);
Route::post('/pengeluaran', [LaporanController::class, 'pengeluaran']);
Route::post('/pb22', [LaporanController::class, 'pb22']);
Route::post('/pb23', [LaporanController::class, 'pb23']);
Route::post('/rekapitulasi', [LaporanController::class, 'rekapitulasi']);
