<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\Replie;
use Illuminate\Support\Facades\Log;

class InfoController extends Controller
{
    // 컨트롤러 확인용 test
    // public function maininfo($name = null): string //값이 없을 경우 null 허용
    // {
    //     return '안녕하세요 from InfoController 이름?'. $name;
    // }

    // info 게시글 조회
    public function getMainInfo() {
        Log::debug("함수진입");
        // 모든 게시글을 조회
        $hits = Info::
        orderby('hits','desc')
        ->limit(4)
        ->get();
        Log::debug("게시글 조회수 4개 조회값 = ".$hits);
        $fixed = Info::where('id', 10)
            ->orWhere('id', 30)
            ->orWhere('id', 50)
            ->get();  
        Log::debug("게시글 조회 결과: " . $fixed);
        return response()->json([
            'code' => '0',
            'hits' => $hits,
            'fixed' => $fixed,
            
        ], 200);
    }
    public function detailget(Request $req) {
        Log::debug("함수진입");
        // 디테일 페이지 게시글정보 조회
        $info_result = Info::
        where('id',$req->id)
        ->get();
        
        $replie_count = Replie::
        where('id',$req->id)
        ->get();

        $replie_result = Replie::
        select('nick','content','created_at')
        ->where('b_id',$req->id)
        ->orderby('created_at','desc')
        ->limit(20)
        ->get();
        Log::debug($replie_result);
        return response()->json([
            'code' => '0',
            'data' => $info_result,
            'replie' => $replie_result,
            'repliecount' => $replie_count,
        ], 200);
    }
    public function repliewirte(Request $req) {
        Log::debug("함수진입");
        $data = $req->only('nick','content','b_id');
        $result = Replie::create($data);
        Log::debug($result);
        return response()->json([
            'code' => '0',
            'data' => $result,
        ], 200);
    }

}
