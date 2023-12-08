<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; //유저컨틀롤러 추가

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


Route::middleware('apiChkToken')->middleware('myValidation')->prefix('signin')->group(function() {
    Route::post('/email', [UserController::class, 'emailchk']);
    Route::post('/nick', [UserController::class, 'nickchk']);
    Route::post('/', [UserController::class, 'store']);
});

Route::middleware('apiChkToken')->middleware('myValidation')->post('/login', [UserController::class, 'login']);

Route::middleware('apiChkToken')->middleware('myValidation')->post('/logout', [UserController::class, 'logout']);