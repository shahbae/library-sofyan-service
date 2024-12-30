<?php

use App\Http\Controllers\AnggotaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::delete('anggota/{id}', [AnggotaController::class, 'destroy']); // Hapus anggota berdasarkan ID


Route::resource('anggota', AnggotaController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);

Route::put('/debug', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'method' => $request->method(),
        'data' => $request->all(),
    ]);
});


