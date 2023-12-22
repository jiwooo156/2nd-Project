<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\Replie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Http;

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
        $hits = Info::where('main_flg', '=', '축제')
        ->orderby('hits','desc')
        ->limit(4)
        ->get();
        Log::debug("게시글 조회수 4개 조회값 = ".$hits);
        $fixed = Info::where('id', 10)
            ->orWhere('id', 30)
            ->orWhere('id', 50)
            ->get();  
        Log::debug("게시글 조회 결과: " . $fixed);
        // 날씨 불러오기 위해서 DB에서 가져왔지만 미사용으로 인한 주석
        // $states = Info::select('states_name')
        // ->where('states_name', '<>', '거창군')
        // ->where('states_name', '<>', '산청군')
        // ->where('states_name', '<>', '함양군')
        // ->groupBy('states_name')
        // ->get();
        return response()->json([
            'code' => '0',
            'hits' => $hits,
            'fixed' => $fixed,
            // 'states' => $states,
        ], 200);
    }
    // 디테일 페이지 정보조회
    public function detailget(Request $req) {
        Log::debug("기본 정보 조회 함수진입");
        $info_result = Info::
        where('id',$req->id)
        ->get();

        $replie_count = Replie::
        where('b_id', $req->id)
        ->count();

        $replie_result = Replie::
        select('id','nick','replie','created_at')
        ->where('b_id',$req->id)
        ->orderby('created_at','desc')
        ->limit(20)
        ->get();
        Log::debug("전체조회완료");
        if(count($info_result)===1){
            Log::debug("이프");
            return response()->json([
                'code' => '0',
                'data' => $info_result,
                'replie' => $replie_result,
                'repliecount' => $replie_count,
            ], 200);
            Log::debug("전송실패");
        }else{
            Log::debug("엘스");
            return response()->json([
                'code' => 'E20',
                'errorMsg' => '게시글 조회에 실패하였습니다',
            ], 200);
        }
    }
    // 댓글작성
    public function repliewirte(Request $req) {
        Log::debug("함수진입");
        $data = $req->only('nick','replie','b_id');
        $result = Replie::create($data);
        Log::debug($result);
        return response()->json([
            'code' => '0',
            'data' => $result,
        ], 200);
    }
    // 댓글삭제
    public function repliedel(Request $req) {
        Log::debug("댓글삭제 함수진입");
        try {
            DB::beginTransaction();
            $auth = Auth::user();
            $result = Replie::destroy($req->id);
            if($result){
                DB::commit();
                return response()->json([
                    'code' => '0'
                ], 200);
            }else{
                return response()->json([
                    'code' => 'E05',
                    'errorMsg' => '댓글 삭제중 오류가 발생 했습니다.'
                ], 400);
            }
        } catch(Exception $e){
            DB::rollback();
            return response()->json([
                'code' => 'E09',
                'errorMsg' => ['회원탈퇴중 오류가 발생했습니다']
            ], 400);
        }
    }
    // 댓글 전체조회    
    public function morereplie(Request $req) {
        Log::debug("모어리플라이함수");
        $replie_result = Replie::
            select('id', 'nick', 'replie', 'created_at')
            ->where('b_id', $req->id)
            ->orderBy('created_at', 'desc')
            ->get();
        Log::debug($replie_result);
        if($replie_result){
            Log::debug("이프");
            return response()->json([
                'code' => '0',
                'data' => $replie_result,
            ], 200);
        }else{
            Log::debug("엘스");
            return response()->json([
                'code' => 'E21',
                'errorMsg' => '댓글 조회에 실패하였습니다',
            ], 200);
        }
    }

    // 시군명 조회
    public function stateget(Request $req) {
        Log::debug("***** stateget start *****");
        Log::debug("request ns : ".$req->ns);
        // 시군명 + 경상북도남도 받아옴
        $state_result1 = Info::select('states_name')
                    ->where('ns_flg','경상남도')
                    ->groupBy('states_name')
                    ->orderBy('states_name')
                    ->get();
        $state_result2 = Info::select('states_name')
                    ->where('ns_flg','경상북도')
                    ->groupBy('states_name')
                    ->orderBy('states_name')
                    ->get();

        // Log::debug("데이터 획득 : ".$state_result);

        
        Log::debug("***** stateget end *****");
        return response()->json([
            'code' => '0',
            'data1' => $state_result1,
            'data2' => $state_result2,
            // Log::debug($state_result)
        ], 200);
    }
    // 추천축제,관광지 조회
    public function recommendfestivalget(Request $req) {
        Log::debug("**** recommendfestivalget start ****");
        Log::debug("**** recommendtourget start ****");

        $recommend_festival = Info::
            select('id','title', 'content', 'img1', 'start_at', 'end_at', 'hits')
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
    // 지역축제,관광지 조회 (유저가 선택 한 지역의)
    public function festivalget(Request $req) {
        Log::debug("**** festivalget start ****");
        Log::debug("request states_name : ".$req->states_name);
        $state_festival = Info::
            select('id','states_name','img1','title','content','start_at','end_at','hits')
            ->where('main_flg','축제')
            ->where('states_name',$req->states_name)
            ->orderBy('start_at','desc')
            ->limit(4)
            ->get();
        $state_tour = Info::
            select('id','states_name','img1','title','content','hits')
            ->where('main_flg','관광')
            ->where('states_name',$req->states_name)
            ->orderBy('start_at','desc')
            ->limit(4)
            ->get();
        Log::debug("**** festivalget end ****");
        return response()->json([
            'code' => '0',
            'sfestival' => $state_festival,
            'stour' => $state_tour,
        ],200);
    }
    // 더보기 조회 (지역축제,관광지)
    public function morefestivalget(Request $req) {
        Log::debug("**** morefestivalget start ****");
        Log::debug("request states_name : ".$req->states_name);
        $more_festival = Info::
            select('id','states_name','img1','title','content','start_at','end_at','hits')
            ->where('main_flg','축제')
            ->where('states_name',$req->states_name)
            ->orderBy('start_at','desc')
            ->limit(4)
            ->offset($req->offset)
            ->get();
        $more_tour = Info::
            select('id','states_name','img1','title','content','start_at','end_at','hits')
            ->where('main_flg','관광')
            ->where('states_name',$req->states_name)
            ->orderBy('start_at','desc')
            ->limit(4)
            ->offset($req->offset)
            ->get();
        Log::debug("**** morefestivalget end ****");
        Log::debug($more_festival);
        Log::debug($more_tour);
        return response()->json([
            'code' => '0',
            'mfestival' => $more_festival,
            'mtour' => $more_tour,
        ],200);
    }
    // 검색결과 조회
    public function searchkeyword(Request $req) {
        Log::debug("****** search start ******");
        $search_result = Info::
            select('id','states_name','title','img1','content','start_at','end_at','hits')
            ->where('states_name',$req->searchstate)
            ->where('start_at',$req->startdate)
            ->where('end_at',$req->enddate)
            ->where('title','like',$req->searchkeyword)
            ->limit(4)
            ->get();
        Log::debug("***** search end *******");
        Log::debug($search_result);
        return response()->json([
            'code' => '0',
            'searchresult' => $search_result,
        ],200);
    }
}
