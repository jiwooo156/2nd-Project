<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log; //로그확인추가
use App\Http\Controllers\UserController; //유저 컨틀롤러 추가
use App\Http\Controllers\InfoController; //인포 컨트롤러 추가
use App\Http\Controllers\CommunityController; //커뮤니티 컨트롤러 추가

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

Route::get('/loginchk', [UserController::class, 'chkauth']);

Route::middleware('myValidation')->prefix('authemail')->group(function() {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::post('/', [UserController::class, 'sendemailauth']);
    Route::post('/resend', [UserController::class, 'resendemailauth']);
    Route::post('/time', [UserController::class, 'addtime']);
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

// 1218 차민지 메인에서 사용될 라우터 생성
// 컨트롤러 생성하고 문지기인 라우터를 연결해줘야 함
Route::middleware('myValidation')->prefix('main')->group(function() {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/info', [InfoController::class, 'getMainInfo']);
});

// 질문&건의 게시판 라우터 생성
Route::middleware('myValidation')->prefix('qna')->group(function() {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/qna', [CommunityController::class, 'getQnaList']);
});

// 디테일 라우터
Route::middleware('myValidation')->prefix('detail')->group(function() {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/info/{id}', [InfoController::class, 'detailget']);
    Route::get('/replie/{id}', [InfoController::class, 'replieget']);
    Route::get('/more', [InfoController::class, 'morereplie']);
    Route::post('/{id}', [InfoController::class, 'repliewirte']);
    Route::post('/del/{id}', [InfoController::class, 'repliedel']);
});

// 자유&정보 게시판 라우터 생성
Route::middleware('myValidation')->prefix('board')->group(function() {
    Route::get('/', function () {
        return view('welcome');
    });
    // 0108 정지우 정보게시판 목록 정보조회
    Route::get('/info', [InfoController::class, 'informationget']);
});


// 커뮤니티 디테일 라우터 생성
Route::middleware('myValidation')->prefix('community')->group(function() {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/info/{id}', [InfoController::class, 'communityget']);
    Route::get('/replie/{id}', [InfoController::class, 'replieget']);
    Route::get('/more', [InfoController::class, 'morereplie']);
    Route::post('/{id}', [InfoController::class, 'repliewirte']);
    Route::post('/del/{id}', [InfoController::class, 'repliedel']);
});

// 게시글 작성 라우터 생성
Route::middleware('myValidation')->prefix('post')->group(function() {
    Route::get('/', function () {
        return view('welcome');
    });
});

// 라우터 확인용 test
//?달면 null허용한다는 뜻
// Route::get('/main/{name?}', [InfoController::class, 'maininfo'])->name('main.info');

Route::get('/user', function () {
    return view('welcome');
});

// 어드민 페이지
Route::middleware('myValidation')->prefix('admin')->group(function() {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/user', [UserController::class, 'adminchk']);
    Route::get('/data/{id}', [UserController::class, 'dataget']);
    Route::post('/data', [UserController::class, 'answerdata']);
    Route::get('/report', [UserController::class, 'reportget']);
    Route::delete('/report', [UserController::class, 'reportdel']);
    Route::post('/report', [UserController::class, 'reportpost']);
    Route::get('/userinfo', [UserController::class, 'userget']);
});

// 1213 정지우 지역페이지 라우터 생성
Route::middleware('myValidation')->prefix('region')->group(function() {
    Route::get('/', function () {
        return view('welcome');
    });
    // 시군명 받아오는 url api
    Route::get('/state', [InfoController::class, 'stateget'])->name('state.get');
    // 추천축제,관광지 받아오는 url api
    Route::get('/recommendf', [InfoController::class, 'recommendfestivalget']);
    // 지역축제,관광지 받아오는 url api
    Route::get('/festivalget/{states_name}',[InfoController::class, 'festivalget']);
    // 더보기 받아오는 url api
    Route::get('/morefestivalget',[InfoController::class, 'morefestivalget']);
    // 검색결과 받아오는 url api
    Route::get('/searchkeyword',[InfoController::class, 'searchkeyword']);
    // 검색 축제 더보기
    Route::get('/moresearchf',[InfoController::class, 'moresearchf']);
    // 검색 관광 더보기
    Route::get('/moresearcht',[InfoController::class, 'moresearcht']);
});



// 잘못된 URL입력시
Route::fallback(function(){
    return redirect('/error');
});

Route::get('/error', function () {
    return view('welcome');
});