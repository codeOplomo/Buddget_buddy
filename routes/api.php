<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpenseController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/expenses', [ExpenseController::class, 'store']);
    Route::put('/expensesUpdate/{id}', [ExpenseController::class, 'update']);
    // Remove the following line if you don't have a 'delete' method in your controller
    Route::delete('/expensesDelete/{id}', [ExpenseController::class, 'destroy']);
    Route::get('/expensesIndex', [ExpenseController::class, 'index']);
});

