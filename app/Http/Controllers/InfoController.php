<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info;

class InfoController extends Controller
{
    // 컨트롤러 확인용 test
    // public function maininfo($name = null): string //값이 없을 경우 null 허용
    // {
    //     return '안녕하세요 from InfoController 이름?'. $name;
    // }

    // info 게시글 조회
    public function getMainPost() {
        // 모든 게시글을 조회
        $infos = Info::all();

        // Log 클래스를 사용하여 디버그 정보 기록
        Log::debug($infos);

        return response()->json([
            'code' => '0',
            'data' => $infos
        ], 200);
    }
}

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoController extends Controller
{
    //
}
