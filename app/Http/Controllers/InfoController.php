<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\Replie;
use App\Models\Like;
use App\Models\Community;
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
    public function getMainInfo(Request $req) {
        Log::debug("함수진입");
        // 모든 게시글을 조회
        $hits = Info::where('main_flg', '=', '축제')
        ->where('end_at','>',$req->today)
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
    // public function detailget(Request $req) {
    //     // 리퀘스트온 아이디값으로 인포테이블 조회
    //     $info_result = Info::
    //     where('id',$req->id)
    //     ->get();
    //     // 리퀘스트 온 쿠키값이 없으면서 조회된값이 1개일시
    //     if(!($req->cookie('hits'.$req->id))&&count($info_result)===1){    
    //         // 조회수 1증가  
    //         try { 
    //             // 트랜잭션 시작
    //             DB::beginTransaction();
    //             // 조회된 값의 조회수 1증가
    //             $info_result[0]->hits++;
    //             // 저장
    //             $info_result[0]->save();
    //             DB::commit();    
    //         // 실패시
    //         } catch(Exception $e){
    //             DB::rollback();
    //         }
    //     // 조회된값이 1개일때
    //     }
    //     if(count($info_result)===1){            
    //         // 리퀘스트온 아이디값으로 댓글테이블의 조회된 값 카운트
    //         $replie_count = Replie::
    //         where('b_id', $req->id)
    //         ->count();
    //         // 리퀘스트온 아이디값으로 댓글테이블에 댓글들 조회(20개 최신순 내림차순)
    //         $replie_result = Replie::
    //         select('replies.id', 'users.nick', 'replies.replie', 'replies.created_at', 'users.email')
    //         ->join('users', 'replies.u_id', '=', 'users.id')
    //         ->where('replies.b_id', $req->id)
    //         ->where('replies.flg', '0')
    //         ->orderBy('replies.created_at', 'desc')
    //         ->limit(20)
    //         ->get();
    //         Log::debug( $replie_result);
    //         return response()->json([
    //             'code' => '0',
    //             'data' => $info_result,
    //             'replie' => $replie_result,
    //             'repliecount' =>  $replie_count,
    //         ], 200)->cookie('hits'.$req->id,'hits'.$req->id, 1);
    //     // 조회된값이 없거나 실패일시
    //     }else{
    //         return response()->json([
    //             'code' => 'E99',
    //             'errorMsg' => '게시글 조회에 실패하였습니다',
    //         ], 200);
    //     }
    // }

    // // 디테일 페이지 정보조회 좋아요있는 버전
    public function detailget(Request $req) {
        // Log::debug("디테일 리퀘스트는 : ".$req);
        // 리퀘스트온 아이디값으로 인포테이블 조회
        $info_result = Info::select(
            'infos.*',
             DB::raw('COALESCE(lik.cnt, 0) as cnt')
        )
        ->leftJoin(DB::raw('(SELECT b_id, COUNT(b_id) as cnt FROM likes WHERE flg = 0 AND deleted_at IS NULL GROUP BY b_id) lik'), 'infos.id', '=', 'lik.b_id')
        ->where('infos.id', $req->id)
        ->get();

        // Log::debug("디테일 좋아요 갯수 : ".$info_result->cnt);
        Log::debug("디테일 결과 : ".$info_result);

        $auth_id = "";
        $result = "";

        if(auth()->check()) {
            Log::debug("로그인상태");
            $auth = Auth::user();
            $auth_id = $auth->id;
            $result = Like::where('u_id',$auth_id)->where('b_id',$req->id)->exists();
            Log::debug("결과");
            Log::debug("좋아요 이력 결과 : ".$result);
        }
        // 리퀘스트 온 쿠키값이 없으면서 조회된값이 1개일시
        if(!($req->cookie('hits'.$req->id))&&count($info_result)===1){    
            // 조회수 1증가  
            try { 
                // 트랜잭션 시작
                DB::beginTransaction();
                // 조회된 값의 조회수 1증가
                $info_result[0]->timestamps = false;
                $info_result[0]->hits++;
                // 저장
                $info_result[0]->save();
                DB::commit();    
            // 실패시
            } catch(Exception $e){
                DB::rollback();
            }
        // 쿠키값이있고 조회된값이 1개일때
        }
        if(count($info_result)===1){            
            // 리퀘스트온 아이디값으로 댓글테이블의 조회된 값 카운트
            $repliecnt = Replie::
            where('b_id', $req->id)
            ->count();
            // 리퀘스트온 아이디값으로 댓글테이블에 댓글들 조회(20개 최신순 내림차순)
            $replieresult = Replie::
            select('replies.id', 'users.nick', 'replies.replie', 'replies.created_at', 'users.email')
            ->join('users', 'replies.u_id', '=', 'users.id')
            ->where('replies.b_id', $req->id)
            ->where('replies.flg', '0')
            ->orderBy('replies.created_at', 'desc')
            ->limit(20)
            ->get();
            Log::debug("댓글 결과 : ".$replieresult);
            Log::debug("댓글 갯수 : ".$repliecnt);
            
            return response()->json([
                'code' => '0',
                'data' => $info_result,
                'replie' => $replieresult,
                'repliecount' =>  $repliecnt,
                'userauth' => $auth_id,
                'likeresult' => $result
            ], 200)->cookie('hits'.$req->id,'hits'.$req->id, 1);
        // 조회된값이 없거나 실패일시
        }else{
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '게시글 조회에 실패하였습니다',
            ], 200);
        }
    }
    // 댓글작성
    public function repliewirte(Request $req) {
        // 리퀘스트온 값중 댓글 보드아이디 data에 저장
        $data = $req->only('replie','b_id','flg');
        // u_id라는 키값에 세션에 저장된 pk값 저장
        $data["u_id"] = Auth::user()->id;
        try { 
            // 트랜잭션 시작
            DB::beginTransaction();
            // data정보를 댓글테이블에 인서트
            $result = Replie::create($data);
            // 저장
            DB::commit();    
            // $result 안에 이메일과 닉네임 추가
            $result->email = Auth::user()->email;
            $result->nick = Auth::user()->nick;
            return response()->json([
                'code' => '0',
                'data' => $result,
            ], 200);
        // 실패시
        } catch(Exception $e){
            // 롤백
            DB::rollback();
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '댓글작성 중 오류가 발생했습니다',
            ], 200);
        }  
        // 정상처리시
    }
    // 댓글삭제
    public function repliedel(Request $req) {
        try {
            // 세션에 저장된 유저정보 조회
            $auth = Auth::user();
            // 세션에 유저정보 닉네임과 일치하고 리퀘스트 온 아이디값으로 유저테이블에 조회
            $result = Replie::
                where('id',$req->id)
                ->where('u_id',$auth->id)->first();
            // 조회결과 있을시
            if($result){
                // 트랜잭션시작
                DB::beginTransaction();
                // 리퀘스트온 아이디값인 데이터 삭제(소프트딜리트처리)
                $result = Replie::destroy($req->id);
                // 저장
                DB::commit();
                return response()->json([
                    'code' => '0'
                ], 200);
            }
        } catch(Exception $e){
            // 롤백
            DB::rollback();
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '댓글삭제 중 오류가 발생했습니다'
            ], 400);
        }
    }
    // 댓글 작성자 확인    
    public function repliechk(Request $req) {
        // 세션에 로그인된 정보 체크
        $result=Auth::user();      
        // 리퀘스트온 이메일과 세션에 이메일 같은지 체크
        // 같을시
        if($result->email===$req->email){
            return response()->json([
                'code' => '0'
            ], 200);
        // 다를시
        }else{
            Log::debug("엘스");
            return response()->json([
                'code' => '1',
            ], 200);
        }
    }

    // 시군명 조회
    public function stateget(Request $req) {
        Log::debug("***** stateget start *****");
        Log::debug("request ns : ".$req->ns);

        // response data 초기화 (정상 처리 아닐시, 에러로 세팅)
        $responseData = [
            'code' => 'E11'
            ,'errorMsg' => 'Parameter Error'
            ,'data' => null
        ];
        $httpCode = 400;

        // 시군명 + 경상북도남도 받아옴
        if($req->ns === '경상남도'||$req->ns === '경상북도') {
            // 경상남도/북도 선택 했을경우에만 데이터 받아오게함.
            // 그래서 선택안하고 url에 직접 입력하면 if에서 걸러지고, 에러페이지 뜨게함.
            $responseData['data'] = 
                Info::select('states_name')
                ->where('ns_flg',$req->ns)
                ->groupBy('states_name')
                ->orderBy('states_name')
                ->get();
            $responseData['code'] = '0';
            $responseData['errorMsg'] = '';
            // 정상처리시 http status code 200번으로 세팅
            $httpCode = 200;
        }
        Log::debug("responseData : ", $responseData);
        Log::debug("***** stateget end *****");

        return response()->json($responseData, $httpCode);
    }
    // 추천축제,관광지 조회
    public function recommendfestivalget(Request $req) {
        Log::debug("**** recommendfestivalget start ****");
        Log::debug("**** recommendtourget start ****");

        $recommend_festival = Info::
            select('id','title', 'content', 'img1', 'start_at', 'end_at', 'hits', 'ns_flg')
            ->where('main_flg','축제')
            ->where('ns_flg',$req->ns)
            ->where('end_at','>',$req->today)
            ->orderBy('hits', 'desc')
            ->limit(3)
            ->get();
        $recommend_tour = Info::
            select('id','title', 'content', 'img1', 'hits', 'ns_flg')
            ->where('main_flg','관광')
            ->where('ns_flg',$req->ns)
            ->orderBy('hits', 'desc')
            ->limit(3)
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
        Log::debug("지역이름 : ".$req->states_name);
        $state_festival = Info::
            select('id','states_name','img1','title','content','start_at','end_at','hits')
            ->where('main_flg','축제')
            ->where('states_name',$req->states_name)
            ->orderBy('start_at','desc')
            ->limit(3)
            ->get();
        $state_festival_cnt = Info::
            select('id','states_name','img1','title','content','start_at','end_at','hits')
            ->where('main_flg','축제')
            ->where('states_name',$req->states_name)
            ->orderBy('start_at','desc')
            ->count();
        $state_tour = Info::
            select('id','states_name','img1','title','content','hits')
            ->where('main_flg','관광')
            ->where('states_name',$req->states_name)
            ->orderBy('id','desc')
            ->limit(3)
            ->get();
        $state_tour_cnt = Info::
            select('id','states_name','img1','title','content','hits')
            ->where('main_flg','관광')
            ->where('states_name',$req->states_name)
            ->orderBy('id','desc')
            ->count();
        Log::debug("**** festivalget end ****");
        Log::debug("축제 : ". $state_festival);
        Log::debug("관광 : ". $state_tour);
        return response()->json([
            'code' => '0',
            'sfestival' => $state_festival,
            'stour' => $state_tour,
            'f_cnt' => $state_festival_cnt,
            't_cnt' => $state_tour_cnt,
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
            ->limit(3)
            ->offset($req->offset)
            ->get();
        $more_tour = Info::
            select('id','states_name','img1','title','content','start_at','end_at','hits')
            ->where('main_flg','관광')
            ->where('states_name',$req->states_name)
            ->orderBy('id','desc')
            ->limit(3)
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
        DB::connection()->enableQueryLog();
        $festival = Info::select('id', 'states_name', 'title', 'img1', 'content', 'start_at', 'end_at', 'hits')
            ->when($req->states_name !== "지역", fn ($query) => $query->where('states_name', $req->states_name))
            ->where('main_flg','축제')
            ->when($req->searchkeyword !== null, fn ($query) => $query->where('title', 'like', '%' . $req->searchkeyword . '%'))
            ->when($req->start_at !== null&&$req->end_at === null, fn ($query) => $query->where('end_at', '>=', $req->start_at))
            ->when($req->end_at !== null&&$req->start_at === null, fn ($query) => $query->where('start_at', '<=', $req->end_at))
            ->when($req->end_at !== null&&$req->start_at !== null, fn ($query) => $query->where('start_at', '<=', $req->end_at)->where('end_at', '>=', $req->start_at))
            ->where('ns_flg',$req->ns)
            ->orderBy('end_at', 'desc')
            ->limit(6)
            ->get();
        $festivalcount = Info::select('id', 'states_name', 'title', 'img1', 'content', 'start_at', 'end_at', 'hits')
            ->when($req->states_name !== "지역", fn ($query) => $query->where('states_name', $req->states_name))
            ->where('main_flg','축제')
            ->when($req->searchkeyword !== null, fn ($query) => $query->where('title', 'like', '%' . $req->searchkeyword . '%'))
            ->when($req->start_at !== null&&$req->end_at === null, fn ($query) => $query->where('end_at', '>=', $req->start_at))
            ->when($req->end_at !== null&&$req->start_at === null, fn ($query) => $query->where('start_at', '<=', $req->end_at))
            ->when($req->end_at !== null&&$req->start_at !== null, fn ($query) => $query->where('start_at', '<=', $req->end_at)->where('end_at', '>=', $req->start_at))
            ->where('ns_flg',$req->ns)
            ->orderBy('end_at', 'desc')
            ->count();
        if($req->searchkeyword !== null||$req->states_name !== "지역"){
            $tour = Info::select('id', 'states_name', 'title', 'img1', 'content', 'start_at', 'end_at', 'hits')
            ->when($req->states_name !== "지역", fn ($query) => $query->where('states_name', $req->states_name))
            ->when($req->searchkeyword !== null, fn ($query) => $query->where('title', 'like', '%' . $req->searchkeyword . '%'))
            ->where('ns_flg',$req->ns)
            ->where('main_flg','관광')
            ->limit(6)
            ->get();
            $tourcount = Info::select('id', 'states_name', 'title', 'img1', 'content', 'start_at', 'end_at', 'hits')
            ->when($req->states_name !== "지역", fn ($query) => $query->where('states_name', $req->states_name))
            ->when($req->searchkeyword !== null, fn ($query) => $query->where('title', 'like', '%' . $req->searchkeyword . '%'))
            ->where('ns_flg',$req->ns)
            ->where('main_flg','관광')
            ->count();
            return response()->json([
                'code' => '0',
                'festival' => $festival,
                'f_cnt' => $festivalcount,
                'tour' => $tour,
                't_cnt' => $tourcount,
            ],200);
        }
        Log::debug(\DB::getQueryLog());
        Log::debug("***** search end *******");
        return response()->json([
            'code' => '0',
            'festival' => $festival,
            'f_cnt' => $festivalcount,
            'tour' => "",
            't_cnt' => 0,
        ],200);
    }
    // 검색 축제 더보기
    public function moresearchf(Request $req) {
        $festival = Info::select('id', 'states_name', 'title', 'img1', 'content', 'start_at', 'end_at', 'hits')
            ->when($req->states_name !== "지역", fn ($query) => $query->where('states_name', $req->states_name))
            ->where('main_flg','축제')
            ->when($req->searchkeyword !== null, fn ($query) => $query->where('title', 'like', '%' . $req->searchkeyword . '%'))
            ->when($req->start_at !== null&&$req->end_at === null, fn ($query) => $query->where('end_at', '>=', $req->start_at)->orderBy('end_at', 'asc'))
            ->when($req->end_at !== null&&$req->start_at === null, fn ($query) => $query->where('start_at', '<=', $req->end_at)->orderBy('end_at', 'desc'))
            ->when($req->end_at !== null&&$req->start_at !== null, fn ($query) => $query->where('start_at', '<=', $req->end_at)->where('end_at', '>=', $req->start_at)->orderBy('end_at', 'asc'))
            ->where('ns_flg',$req->ns)
            ->limit(6)
            ->offset($req->offset)
            ->get();
        return response()->json([
            'code' => '0',
            'festival' => $festival,
        ],200);
    }
    // 유저 좋아요 누른 정보들 조회
    public function userlikeget(Request $req) {
        $auth = Auth::user();
        // 축제
        if($req->flg === "0"){
            $data = Like::select('infos.id','infos.title','infos.img1 as img','infos.start_at','infos.end_at','infos.main_flg as flg')
            ->join('infos','likes.b_id','infos.id')
            ->where('infos.main_flg','축제')
            ->where('likes.flg','0');
        }else if($req->flg === "1"){
            $data = Like::select('infos.id','infos.title','infos.img1 as img','infos.start_at','infos.end_at','infos.main_flg as flg')
            ->join('infos','likes.b_id','infos.id')
            ->where('infos.main_flg','관광')
            ->where('likes.flg','0');
        }else if($req->flg === "2"){
            $data = Like::select('community.id','community.title','community.flg')
            ->join('community','likes.b_id','community.id')
            ->where('likes.flg','1');
        }
            $data = $data
                ->where('likes.u_id',$auth->id)
                ->paginate(3);
            Log::debug($data);
        return response()->json([
            'code' => '0',
            'data' => $data,
        ],200);
    }
    // 유저 작성 정보들 조회
    public function userwriteget(Request $req) {
        $auth = Auth::user();
        Log::debug("진입");
        if($req->flg === "0"){
            Log::debug("작성게시글");
            $data = Community::where('u_id',$auth->id);
        }else if($req->flg === "1"){
            Log::debug("작성댓글");
            $data = Replie::select('infos.title', 'infos.main_flg as flg', 'replies.replie', 'replies.created_at')
            ->where('replies.u_id', $auth->id)
            ->join('infos', 'replies.b_id', 'infos.id');
    
            $data = $data->union(Replie::select('community.title', 'community.flg', 'replies.replie', 'replies.created_at')
                ->where('replies.u_id', $auth->id)
                ->join('community', 'replies.b_id', 'community.id'));
        }
            $data = $data
                ->orderby('created_at','desc')
                ->paginate(8);
            Log::debug($data);
        return response()->json([
            'code' => '0',
            'data' => $data,
        ],200);
    }
    // 검색 관광 더보기
    public function moresearcht(Request $req) {
        $tour = Info::select('id', 'states_name', 'title', 'img1', 'content', 'start_at', 'end_at', 'hits')
            ->when($req->states_name !== "지역", fn ($query) => $query->where('states_name', $req->states_name))
            ->when($req->searchkeyword !== null, fn ($query) => $query->where('title', 'like', '%' . $req->searchkeyword . '%'))
            ->where('main_flg','관광')
            ->where('ns_flg',$req->ns)
            ->limit(6)
            ->offset($req->offset)
            ->get();
        return response()->json([
            'code' => '0',
            'tour' => $tour,
        ],200);
    }


    // 0112 정지우 정보게시판 페이지 정보조회 (목록)
    public function commuinfoget(Request $req) {
        Log::debug("**** commuinfoget start ****");
        Log::debug("게시판 플래그 : ".$req->flg);
        Log::debug("카테고리 플래그 : ".$req->category);
        Log::debug("정렬순 플래그 : ".$req->orderby);
        Log::debug("정렬순 플래그 타입 : ".gettype($req->orderby));
        Log::debug("인포함수진입");

        $informresult = Community::select(
            'community.id',
            'community.category_flg',
            'community.title',
            'community.created_at',
            'community.hits',
            'users.nick',
            DB::raw('COALESCE(lik.cnt, 0) as cnt')
        )
        ->leftjoin('users', 'community.u_id', '=', 'users.id')
        ->leftJoin(DB::raw('(SELECT b_id, COUNT(b_id) as cnt FROM likes WHERE flg = 1 AND deleted_at IS NULL GROUP BY b_id) lik'), 'community.id', '=', 'lik.b_id')
        ->where('community.flg', $req->flg)
        ->where('community.notice_flg', "0")
        ->where('community.deleted_at', null);

        $infocnt = Community::select(
            'community.id',
            'community.category_flg',
            'community.title',
            'community.created_at',
            'community.hits',
            'users.nick',
            DB::raw('COALESCE(lik.cnt, 0) as cnt')
        )
        ->leftjoin('users', 'community.u_id', '=', 'users.id')
        ->leftJoin(DB::raw('(SELECT b_id, COUNT(b_id) as cnt FROM likes WHERE flg = 1 AND deleted_at IS NULL GROUP BY b_id) lik'), 'community.id', '=', 'lik.b_id')
        ->where('community.flg', $req->flg)
        ->where('community.deleted_at', null);

        $noticeresult = Community::select(
            'community.id',
            'community.category_flg',
            'community.title',
            'community.created_at',
            'community.hits',
            'community.notice_flg',
            'users.nick',
            DB::raw('COALESCE(lik.cnt, 0) as cnt')
        )
        ->join('users', 'community.u_id', '=', 'users.id')
        ->leftJoin(DB::raw('(SELECT b_id, COUNT(b_id) as cnt FROM likes WHERE flg = 1 AND deleted_at IS NULL GROUP BY b_id) lik'), 'community.id', '=', 'lik.b_id')
        ->where('community.flg', $req->flg)
        ->where('community.notice_flg', "1")
        ->where('community.deleted_at', null)
        ->get();

        Log::debug("category_flg 타입 : ".gettype($req->category));
        if (!($req->category === "3")) {
            Log::debug("category_flg 있음");
            $informresult
                ->where('community.category_flg', $req->category);
        }

        if ($req->orderby) {
            Log::debug("orderby flg 있음");
            Log::debug("orderby : ".$req->orderby);
            if($req->orderby === '1') {
                $informresult->orderBy('community.created_at', 'desc');
            } else if ($req->orderby === '2') {
                $informresult->orderBy('community.hits', 'desc');
            } else if ($req->orderby === '3') {
                $informresult->orderBy('lik.cnt', 'desc');
            }
        }

        $informresult->get();
        $infocnt = $informresult->count();

        $informresult = $informresult->paginate(10);

        Log::debug($informresult);
        Log::debug($infocnt);
        Log::debug($noticeresult);
        Log::debug("게시글 타입은 : ".gettype($informresult));
        Log::debug("공지사항 타입은 : ".gettype($noticeresult));
        
        return response()->json([
            'code' => '0',
            'information' => $informresult,
            'infocnt' => $infocnt,
            'noticedata' => $noticeresult,
        ], 200);          
    }
    // 0117 정지우 정보게시판 공지사항 정보조회 
    // public function noticeget(Request $req) {
    //     Log::debug("**** noticeget start ****");
    //     Log::debug("게시판 플래그 : ".$req->flg);
    //     Log::debug("공지함수진입");

    //     $noticeresult = Community::select(
    //         'community.id',
    //         'community.category_flg',
    //         'community.title',
    //         'community.created_at',
    //         'community.hits',
    //         'users.nick',
    //         DB::raw('COALESCE(lik.cnt, 0) as cnt')
    //     )
    //     ->join('users', 'community.u_id', '=', 'users.id')
    //     ->leftJoin(DB::raw('(SELECT b_id, COUNT(b_id) as cnt FROM likes WHERE flg = 1 AND deleted_at IS NULL GROUP BY b_id) lik'), 'community.id', '=', 'lik.b_id')
    //     ->where('community.flg', $req->flg)
    //     ->where('community.deleted_at', null);

    //     $noticeresult->get();

    //     Log::debug($noticeresult);
        
    //     return response()->json([
    //         'code' => '0',
    //         'data' => $noticeresult,
    //     ], 200);          
    // }
    
    // 0112 정지우 커뮤니티 디테일 페이지 정보조회 
    public function communityget(Request $req) {
        Log::debug("**** communityget start ****");
        Log::debug("커뮤디테일 함수진입");
        // 리퀘스트온 아이디값으로 커뮤니티 테이블 조회
        $communityresult = Community::select(
                'community.id',
                'community.u_id',
                'community.flg',
                'community.category_flg',
                'community.title',
                'community.content',
                'community.created_at',
                'community.updated_at',
                'community.deleted_at',
                'community.hits',
                'community.notice_flg',
                'users.nick',
                DB::raw('COALESCE(lik.cnt, 0) as cnt')
            )
            ->join('users', 'community.u_id', '=', 'users.id')
            ->leftJoin(DB::raw('(SELECT b_id, COUNT(b_id) as cnt FROM likes WHERE flg = 1 AND deleted_at IS NULL GROUP BY b_id) lik'), 'community.id', '=', 'lik.b_id')
            ->where('community.id',$req->id)
            ->get();

        Log::debug("커뮤니티결과 : ".$communityresult);
        
        // 유저정보 초기화
        $auth_id = "";
        $result = "";

        // 로그인 시 해당유저 정보로 likes 테이블 조회
        if(auth()->check()) {
            Log::debug("로그인상태");
            $auth = Auth::user();
            $auth_id = $auth->id;
            $result = Like::where('u_id',$auth_id)
            ->where('b_id',$req->id)
            ->exists();
            Log::debug("결과");
            Log::debug($result);
            Log::debug("결과 타입 : ".gettype($result));
        }
        
        // 리퀘스트 온 쿠키값이 없으면서 조회된값이 1개일시
        if(!($req->cookie('hits'.$req->id))&&count($communityresult)===1){    
            // 조회수 1증가  
            try { 
                // 트랜잭션 시작
                DB::beginTransaction();
                // 조회된 값의 조회수 1증가
                $communityresult[0]->timestamps = false;
                $communityresult[0]->hits++;
                // 저장
                $communityresult[0]->save();
                DB::commit();    
            // 실패시
            } catch(Exception $e){
                DB::rollback();
            }
        // 쿠키값이있고 조회된값이 1개일때
        }
        if(count($communityresult)===1){            
            // 리퀘스트온 아이디값으로 댓글테이블의 조회된 값 카운트
            $repliecnt = Replie::
            where('b_id', $req->id)
            ->count();
            // 리퀘스트온 아이디값으로 댓글테이블에 댓글들 조회(20개 최신순 내림차순)
            $replieresult = Replie::
            select('replies.id', 'users.nick', 'replies.replie', 'replies.created_at', 'users.email')
            ->join('users', 'replies.u_id', '=', 'users.id')
            ->where('replies.b_id', $req->id)
            ->where('replies.flg', '1')
            ->orderBy('replies.created_at', 'desc')
            ->limit(20)
            ->get();
            Log::debug("댓글 결과 : ".$replieresult);
            Log::debug("댓글 갯수 : ".$repliecnt);
            
            return response()->json([
                'code' => '0',
                'data' => $communityresult,
                'replie' => $replieresult,
                'repliecount' =>  $repliecnt,
                'userauth' => $auth_id,
                'likeresult' => $result
            ], 200)->cookie('hits'.$req->id,'hits'.$req->id, 1);
        // 조회된값이 없거나 실패일시
        }else{
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '게시글 조회에 실패하였습니다',
            ], 200);
        }
    }

    // 0115 정지우 커뮤니티 게시글 작성
    public function communitywrite(Request $req) {
        Log::debug("communitywrite 함수 시작");
        Log::debug($req);
        // 리퀘스트온 값 data에 저장
        $data = $req->only('flg','category_flg','title','content');
        // u_id라는 키값에 세션에 저장된 pk값 저장
        $data["u_id"] = Auth::user()->id;
        // Log::debug("작성데이터 : ".$data);
        try { 
            Log::debug("communitywrite try");
            // 트랜잭션 시작
            DB::beginTransaction();
            // data정보를 커뮤니티 테이블에 인서트
            $result = community::create($data);
            // 저장
            DB::commit();
            return response()->json([
                'code' => '0',
                'data' => $result,
            ], 200);
        // 실패시
        } catch(Exception $e){
            Log::debug("communitywrite catch");
            // 롤백
            DB::rollback();
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '게시글 작성 중 오류가 발생했습니다',
            ], 200);
        }  
        // 정상처리시
    }


    // 0116 정지우 좋아요 작성
    public function plusheart(Request $req) {
    Log::debug("plusheart 함수 시작");
    Log::debug($req);

    // 리퀘스트 온 값 data에 저장
    $data = $req->only('b_id', 'flg');
    $data["u_id"] = Auth::user()->id;
    Log::debug($data);

    // 로그인 여부 확인
    if (auth()->check()) {
        Log::debug("로그인 상태");
        $auth_id = auth()->id();
        Log::debug($auth_id);

        // 해당 유저의 like 이력 조회 (있으면 true, 없으면 false)

        try {
            Log::debug("plusheart try");
            // 트랜잭션 시작
            DB::beginTransaction();
            $likehistory = Like::where('u_id', $auth_id)
            ->where('b_id', $req->b_id)
            ->exists();
            Log::debug("결과");
            Log::debug($likehistory);
            Log::debug(gettype($likehistory));
            // 좋아요 이력이 없으면 생성, 있으면 삭제
            if (!$likehistory) {
                // data 정보를 커뮤니티 테이블에 인서트
                $result = Like::create($data);
                Log::debug('여기는 생성이야'. $result);
                $likehistory = true;
            } else {
                // data 정보를 커뮤니티 테이블에서 삭제 (소프트딜리트)
                $result = Like::where('u_id', $auth_id)
                ->where('b_id', $req->b_id)
                ->delete();
                Log::debug('여기는 삭제야'. $result);
                $likehistory = false;
            }

            // 저장
            DB::commit();
            Log::debug($likehistory);
    
            return response()->json([
                'code' => '0',
                'data' => $result,
                'likeflg' => $likehistory
            ], 200);
        } catch (Exception $e) {
            Log::debug("plusheart catch");
            // 롤백
            DB::rollback();

            return response()->json([
                'code' => 'E99',
                'errorMsg' => '게시글 작성 중 오류가 발생했습니다',
            ], 200);
        }
    } else {
        Log::debug("로그인 상태 아님");
        // 로그인되어 있지 않으면 에러 응답
        return response()->json([
            'code' => 'E99',
            'errorMsg' => '로그인 후 이용해 주세요.',
        ], 200);
    }
}

    // 차민지 3차를 위한 컨트롤러
    // 커뮤니티 질문&정보 게시판 리스트 조회
    public function informationget(Request $req) {
        $informresult = Community::select(
            'community.id',
            'community.category_flg',
            'community.title',
            'community.created_at',
            'community.hits',
            'users.nick',
            'community.admin_flg',
            DB::raw('COALESCE(lik.cnt, 0) as cnt')
        )
        ->leftJoin('users', 'community.u_id', '=', 'users.id')
        ->leftJoin(DB::raw('(SELECT b_id, COUNT(b_id) as cnt FROM likes WHERE flg = 1 AND deleted_at IS NULL GROUP BY b_id) lik'), 'community.id', '=', 'lik.b_id')
        ->where('community.flg', $req->flg)
        ->where('community.notice_flg', "0")
        ->whereNull('community.deleted_at');

        $infocnt = Community::select(
            'community.id',
            'community.category_flg',
            'community.title',
            'community.created_at',
            'community.hits',
            'users.nick',
            DB::raw('COALESCE(lik.cnt, 0) as cnt')
        )
        ->leftJoin('users', 'community.u_id', '=', 'users.id')
        ->leftJoin(DB::raw('(SELECT b_id, COUNT(b_id) as cnt FROM likes WHERE flg = 1 AND deleted_at IS NULL GROUP BY b_id) lik'), 'community.id', '=', 'lik.b_id')
        ->where('community.flg', $req->flg)
        ->whereNull('community.deleted_at');

        $noticeresult = Community::select(
            'community.id',
            'community.category_flg',
            'community.title',
            'community.created_at',
            'community.hits',
            'community.notice_flg',
            'community.admin_flg',
            'users.nick',
            DB::raw('COALESCE(lik.cnt, 0) as cnt')
        )
        ->leftjoin('users', 'community.u_id', '=', 'users.id')
        ->leftJoin(DB::raw('(SELECT b_id, COUNT(b_id) as cnt FROM likes WHERE flg = 1 AND deleted_at IS NULL GROUP BY b_id) lik'), 'community.id', '=', 'lik.b_id')
        ->where('community.flg', $req->flg)
        ->where('community.notice_flg', "1")
        ->where('community.deleted_at', null)
        ->get();

        Log::debug("category_flg 타입 : ".gettype($req->category));
        if (!($req->category === "3")) {
            Log::debug("category_flg 있음");
            $informresult
                ->where('community.category_flg', $req->category);
        }

        if ($req->orderby) {
            Log::debug("orderby flg 있음");
            Log::debug("orderby : ".$req->orderby);
            if($req->orderby === '1') {
                $informresult->orderBy('community.created_at', 'desc');
            } else if ($req->orderby === '2') {
                $informresult->orderBy('community.hits', 'desc');
            } else if ($req->orderby === '3') {
                $informresult->orderBy('lik.cnt', 'desc');
            }
        }

        $informresult->get();
        $infocnt = $informresult->count();

        $informresult = $informresult->paginate(12);

        Log::debug($informresult);
        Log::debug($infocnt);
        Log::debug($noticeresult);

        return response()->json([
            'code' => '0',
            'data' => $informresult,
            'infocnt' => $infocnt,
            'noticedata' => $noticeresult,
        ], 200);          
    }

    // 커뮤니티 질문&건의 디테일 페이지 조회
    public function detailComget(Request $req) {
        // 리퀘스트온 아이디값으로 커뮤니티테이블 조회
        $com_result = community::
        join('users', 'community.u_id', '=', 'users.id')
        ->leftJoin(DB::raw('(SELECT b_id, COUNT(b_id) as cnt FROM likes WHERE flg = 1 AND deleted_at IS NULL GROUP BY b_id) lik'), 'community.id', '=', 'lik.b_id')
        ->where('community.id',$req->id)
        ->select('community.*', 'users.nick', 'users.email', DB::raw('COALESCE(lik.cnt, 0) as cnt'))
        ->get();
        // 리퀘스트 온 쿠키값이 없으면서 조회된값이 1개일시
        if(!($req->cookie('hits'.$req->id))&&count($com_result)===1){    
            // 조회수 1증가  
            try { 
                // 트랜잭션 시작
                DB::beginTransaction();
                // 조회된 값의 조회수 1증가
                $com_result[0]->timestamps = false;
                $com_result[0]->hits++;
                // 저장
                $com_result[0]->save();
                DB::commit();    
            // 실패시
            } catch(Exception $e){
                DB::rollback();
            }
        }
        // 조회된값이 1개일때
        if(count($com_result)===1){            
            // 리퀘스트온 아이디값으로 댓글테이블의 조회된 값 카운트
            $replie_count = Replie::
            where('b_id', $req->id)
            ->count();
            // 리퀘스트온 아이디값으로 댓글테이블에 댓글들 조회(20개 최신순 내림차순)
            $replie_result = Replie::
            select('replies.id', 'users.nick', 'replies.replie', 'replies.created_at', 'users.email')
            ->join('users', 'replies.u_id', '=', 'users.id')
            ->where('replies.b_id', $req->id)
            ->where('replies.flg', '1')
            ->orderBy('replies.created_at', 'desc')
            ->limit(20)
            ->get();
            Log::debug($replie_result);
            return response()->json([
                'code' => '0',
                'data' => $com_result,
                'replie' => $replie_result,
                'repliecount' => $replie_count,
            ], 200)->cookie('hits'.$req->id,'hits'.$req->id, 1);
        // 조회된값이 없거나 실패일시
        }else{
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '게시글 조회에 실패하였습니다',
            ], 200);
        }
    }
    // 커뮤니티 질문&건의 삭제
    public function postdelete(Request $req){
        try {
            // 트랜잭션시작
            DB::beginTransaction();
            // 삭제처리
            $result = Community::
                where('id',$req->id)
                ->delete();
            DB::commit();
            return response()->json([
                'code' => '0'
            ], 200);
        } catch(Exception $e){
            // 롤백
            DB::rollback();
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '삭제 실패.'
            ], 400);
        }
    }
    // 커뮤니티 질문&건의 수정
    public function postupdate(Request $req){
        // Log::debug("수정 함수 시작");
        // Log::debug($req);
        // Log::debug("제목 플래그 : ".$req->title);
        // Log::debug("내용 플래그 : ".$req->content);
        // Log::debug("게시판 플래그 : ".$req->flg);
        // Log::debug("카테고리 플래그 : ".$req->category_flg);
        try {
            // 트랜잭션시작
            DB::beginTransaction();
            // 조회
            $data = Community::where('id',$req->id)->first();
            $data->title = $req->title;
            $data->content = $req->content;
            $data->flg = $req->flg;
            $data->category_flg = $req->category_flg;

            if ($req->hasFile('img1')) {
                $imgName = Str::uuid().'.'.$req->img1->extension();
                $req->img1->move(public_path('img'), $imgName);
                $data->img1 = '/img/'.$imgName;
            }
            if ($req->hasFile('img2')) {
                $imgName = Str::uuid().'.'.$req->img1->extension();
                $req->img1->move(public_path('img'), $imgName);
                $data->img1 = '/img/'.$imgName;
            }
            if ($req->hasFile('img3')) {
                $imgName = Str::uuid().'.'.$req->img1->extension();
                $req->img1->move(public_path('img'), $imgName);
                $data->img1 = '/img/'.$imgName;
            }

            $data->save();
            DB::commit();
            
            return response()->json([
                'code' => '0'
            ], 200);
        } catch(Exception $e){
            // 롤백
            DB::rollback();
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '수정 실패.'
            ], 400);
        }
    }
}