<?php

use App\Http\Controllers\BarangController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {

    // barang controller
    Route::controller(BarangController::class)->group(function () {
        Route::get('/getbarang', 'index');
        Route::post('/postbarang', 'store');
        Route::get('/getidbarang/{uuid}', 'show');
        Route::patch('/updatebarang/{uuid}', 'update');
        Route::delete('/deletebarang/{uuid}', 'destroy');
    });
});
