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
        Log::debug($req->id);
        // 모든 게시글을 조회
        $info_result = Info::
        where('id',$req->id)
        ->get();
        $replie_result = Replie::
        select('nick','content','created_at')
        ->where('b_id',$req->id)
        ->get();
        return response()->json([
            'code' => '0',
            'data' => $info_result,
            'replie' => $replie_result,
        ], 200);
    }
    // 시군명 조회
    public function stateget(Request $req) {
        Log::debug("***** stateget start *****");
        Log::debug("request ns : ".$req->ns);
        
        $state_result = Info::select('states_name')
                    ->where('ns_flg',$req->ns)
                    ->groupBy('states_name')
                    ->orderBy('states_name')
                    ->get();

        Log::debug("데이터 획득 : ".$state_result);

        
        Log::debug("***** stateget end *****");
        return response()->json([
            'code' => '0',
            'data' => $state_result,
            Log::debug($state_result)
        ], 200);
    }
    // 추천축제,관광지 조회
    public function recommendfestivalget(Request $req) {
        Log::debug("**** recommendfestivalget start ****");
        Log::debug("**** recommendtourget start ****");

        $recommend_festival = Info::
        select('id','title', 'content', 'img1', 'hits')
        ->where('main_flg','축제')
        ->orderBy('hits', 'desc')
        ->limit(4)
        ->get();
        $recommend_tour = Info::
        select('id','title', 'content', 'img1', 'hits')
        ->where('main_flg','관광')
        ->orderBy('hits', 'desc')
        ->limit(4)
        ->get();

        Log::debug("데이터 획득 : ".$recommend_festival.$recommend_tour);

        Log::debug("**** recommendfestivalget end ****");
        Log::debug("**** recommendtourget end ****");
        return response()->json([
            'code' => '0',
            'rfestival' => $recommend_festival,
            'rtour' => $recommend_tour,
        ],200);
    }
    // 지역축제 조회
    // public function festivalget(Request $req) {
    //     Log::debug("**** festivalget start ****");

    //     $state_festival = Info::
    //     select('id','state_name','title','content','start_at','end_at')
    //     ->where('main_flg','축제')
    //     ->where('states_name','')
    //     ->orderBy()
    // }
}
