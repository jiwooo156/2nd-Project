<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; //유저컨틀롤러 추가
use Illuminate\Support\Facades\Log; //로그확인추가

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

// Route::middleware('apiChkToken')->middleware('myValidation')->prefix('signin')->group(function() {
// 1211 최정훈 수정 세션에서 로그인 auth로 관리하기에 베어러 토큰 필요 x
Route::middleware('myValidation')->prefix('authemail')->group(function() {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::post('/', [UserController::class, 'sendemailauth']);
});

Route::get('/signinchk', [UserController::class, 'tokenchk']);

Route::middleware('myValidation')->prefix('signin')->group(function() {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/email', [UserController::class, 'emailchk']);
    Route::get('/nick', [UserController::class, 'nickchk']);
    Route::get('/start', [UserController::class, 'emailload']);
    Route::post('/', [UserController::class, 'store']);
});
Route::middleware('myValidation')->prefix('login')->group(function() {
    Route::post('/', [UserController::class, 'login']);
    Route::get('/', function () {
        return view('welcome');
    });
});
Route::get('/logout', [UserController::class, 'logout']);


Route::middleware('myValidation')->prefix('userchk')->group(function() {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::post('/', [UserController::class, 'userchk']);
});

Route::middleware('myValidation')->prefix('userinfo')->group(function() {
    Route::get('/', [UserController::class, 'userinfo']);
});

    Route::get('/userinfo', [UserController::class, 'userinfo']);

Route::middleware('myValidation')->prefix('user')->group(function() {
    Route::post('/pchk', [UserController::class, 'changepw']);
    Route::post('/nchk', [UserController::class, 'changenick']);
    Route::post('/del', [UserController::class, 'deluser']);
});
Route::get('/', function () {
    return view('welcome');
});


Route::get('/main', function () {
    return view('welcome');
});
Route::get('/user', function () {
    return view('welcome');
});
Route::get('/region', function () {
    return view('welcome');
});
Route::get('/error', function () {
    return view('welcome');
});



// 잘못된 URL입력시
Route::fallback(function(){
    return redirect('/error');
});

Route::get('/error', function () {
    return view('welcome');
});