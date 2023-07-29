<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\TransactionController;

Route::prefix('transfert')->group(function () {
    // Afficher la page de transfert avec les liens vers les différents services
    Route::get('/', function () {
        return view('transfert');
    });

    // Endpoints pour les transferts Orange Money
    Route::prefix('orange-money')->group(function () {
        Route::get('/', [TransactionController::class, 'getOrangeMoneyTransactions']);
        Route::get('/avec-code', [TransactionController::class, 'makeOrangeMoneyTransferWithCode']);
        Route::get('/sans-code', [TransactionController::class, 'makeOrangeMoneyTransferWithoutCode']);
    });

    // Endpoints pour les transferts Wave
    Route::get('/wave', [TransactionController::class, 'getWaveTransactions']);

    // Endpoints pour les transferts Wari
    Route::get('/wari', [TransactionController::class, 'getWariTransactions']);

    // Endpoints pour les transferts CB
    Route::prefix('cb')->group(function () {
        Route::get('/', [TransactionController::class, 'getCBTransactions']);
        Route::get('/permanent', [TransactionController::class, 'makePermanentCBTransfer']);
        Route::get('/immediat', [TransactionController::class, 'makeImmediateCBTransfer']);
    });
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
