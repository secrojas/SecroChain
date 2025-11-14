<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\BlockchainController;

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

// Public routes (no authentication required)
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('api.auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');
});

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('api.auth.logout');
        Route::get('/me', [AuthController::class, 'me'])->name('api.auth.me');
    });

    // Account routes
    Route::prefix('accounts')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('api.accounts.index');
        Route::post('/', [AccountController::class, 'store'])->name('api.accounts.store');
        Route::get('/{code}', [AccountController::class, 'show'])->name('api.accounts.show');
        Route::post('/{id}/deposit', [AccountController::class, 'deposit'])->name('api.accounts.deposit');
        Route::post('/{id}/withdraw', [AccountController::class, 'withdraw'])->name('api.accounts.withdraw');
        Route::post('/transfer', [AccountController::class, 'transfer'])->name('api.accounts.transfer');
        Route::get('/{id}/stats', [AccountController::class, 'stats'])->name('api.accounts.stats');
        Route::get('/{id}/transactions', [AccountController::class, 'transactions'])->name('api.accounts.transactions');
        Route::patch('/{id}/activate', [AccountController::class, 'activate'])->name('api.accounts.activate');
        Route::patch('/{id}/deactivate', [AccountController::class, 'deactivate'])->name('api.accounts.deactivate');
    });

    // Transaction routes
    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('api.transactions.index');
        Route::get('/recent', [TransactionController::class, 'recent'])->name('api.transactions.recent');
        Route::get('/type/{type}', [TransactionController::class, 'byType'])->name('api.transactions.byType');
        Route::get('/date-range', [TransactionController::class, 'dateRange'])->name('api.transactions.dateRange');
        Route::get('/{id}', [TransactionController::class, 'show'])->name('api.transactions.show');
        Route::get('/{id}/block', [TransactionController::class, 'withBlock'])->name('api.transactions.withBlock');
    });

    // Blockchain routes
    Route::prefix('blockchain')->group(function () {
        Route::get('/stats', [BlockchainController::class, 'stats'])->name('api.blockchain.stats');
        Route::get('/verify', [BlockchainController::class, 'verify'])->name('api.blockchain.verify');
        Route::get('/blocks', [BlockchainController::class, 'index'])->name('api.blockchain.blocks.index');
        Route::get('/blocks/recent', [BlockchainController::class, 'recent'])->name('api.blockchain.blocks.recent');
        Route::get('/blocks/latest', [BlockchainController::class, 'latest'])->name('api.blockchain.blocks.latest');
        Route::get('/blocks/{id}', [BlockchainController::class, 'show'])->name('api.blockchain.blocks.show');
        Route::get('/blocks/hash/{hash}', [BlockchainController::class, 'findByHash'])->name('api.blockchain.blocks.findByHash');
        Route::get('/blocks/transaction/{transactionId}', [BlockchainController::class, 'findByTransaction'])->name('api.blockchain.blocks.findByTransaction');
    });
});
