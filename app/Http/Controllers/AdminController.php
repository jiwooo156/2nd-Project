<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Community;
use App\Models\Replie;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Scheduling\Schedule;

class AdminController extends Controller
{
    
    // 어드민페이지 시작
    public function adminchk(Request $req)
    {
        Auth::user();
        $chk = Admin::where('u_id',Auth::user()->id)->get();
        if($req->id==Auth::user()->id && $req->nick === Auth::user()->nick && $req->email === Auth::user()->email && count($chk)>0){
            // 오늘 탈퇴자수
            $out = User::withTrashed()
                ->select('deleted_at')
                ->where('deleted_at', '>=', $req->today)
                ->count ();
            Log::debug($req->today);
            // 오늘 가입자수
            $in = User::
                where('created_at','>=', $req->today)
                ->count();
            // 신규질문
            $data = Community::
                select('users.email','community.*')
                ->where('community.flg', "3")
                ->join('users', 'community.u_id', '=', 'users.id')
                ->where('community.admin_flg', 0)
                ->orderby('community.created_at','asc')
                ->limit(5)
                ->get();
            $datacnt = Community::
                select('users.email','community.*')
                ->where('community.flg', "3")
                ->join('users', 'community.u_id', '=', 'users.id')
                ->where('community.admin_flg', 0)
                ->orderby('community.created_at','asc')
                ->count();
            Log::debug($data);
            // 신고목록
            $report = Report::
                select('users.email','reports.*')
                ->where('reports.admin_flg', 0)
                ->join('users', 'reports.u_id', '=', 'users.id')
                ->orderby('reports.created_at','asc')
                ->limit(5)
                ->get();
            $reportcnt = Report::
                select('users.email','reports.*')
                ->where('reports.admin_flg', 0)
                ->join('users', 'reports.u_id', '=', 'users.id')
                ->orderby('reports.created_at','asc')
                ->count();
            return response()->json([
                'code' => '0',
                'sign_cnt' => $in,
                'drop_cnt' => $out,
                'data' => $data,
                'd_cnt' => $datacnt,
                'r_data' => $report,
                'r_cnt' => $reportcnt,
            ], 200);
        }else{
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '인증과정중 문제가 발생했습니다. 다시 한번 로그인후 이용해 주세요'
            ], 400);
        }
    }
    // modal용 report data획득
    public function reportget(Request $req){
        if($req->flg==="0"){
            Log::debug("보드일때");
            $data = Community::withTrashed()
            ->select('users.email','community.*','reports.restraint_at')
            ->where('community.id',$req->b_id)
            ->join('users', 'community.u_id', '=', 'users.id')
            ->leftjoin('reports', 'community.u_id', '=', 'reports.r_id')
            ->first();
        }else{
            $data = Replie::withTrashed()
            ->select('users.email','replies.*','reports.restraint_at')
            ->where('replies.id',$req->b_id)
            ->join('users', 'replies.u_id', '=', 'users.id')
            ->leftjoin('reports', 'replies.u_id', '=', 'reports.r_id')
            ->first();
            Log::debug("댓글일때");
            Log::debug($data);
        }
        return response()->json([
            'code' => '0',
            'data' => $data,
        ], 200);
    }
    // 답변달기
    public function answerdata(Request $req){
        try {
            // 리퀘스트온 아이디 값으로 커뮤니티 테이블 조회
            $data = Community::withTrashed()
            ->where('id',$req->id)
            ->first();
            Log::debug($data);
            if($data->deleted_at !== null){
                return response()->json([
                    'code' => '1',
                    'errorMsg' => '유저가 삭제한 게시글입니다.'
                ], 400);
            }
            // 트랜잭션시작
            DB::beginTransaction();
            // 리퀘스트온 replie추가
            $replie = $req->only('replie');
            // 인서트할 데이터 추가
            $replie['b_id'] = $req->id;
            $replie['u_id'] = Auth::user()->id;
            $replie['flg'] = '1';
            // 처리결과를 인서트
            $result = Replie::create($replie);
            // 인서트 정상시
            if($result){
                // 조회된 값의 어드민플레그 1로 변경
                $data->admin_flg = "1";
            }
            // 변경한 값 저장
            $data->save();
            // 저장
            DB::commit();
            return response()->json([
                'code' => '0'
            ], 200);
        } catch(Exception $e){
            // 롤백
            DB::rollback();
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '댓글 달기 실패.'
            ], 400);
        }
    }
    // 게시글 삭제
    public function reportdel(Request $req){
        try {
            // 트랜잭션시작
            DB::beginTransaction();
            // 삭제처리
            Log::debug($req->flg);
            if($req->flg==="1"){
                $data = Report::
                    where('b_id',$req->id)
                    ->where('flg',1)
                    ->first();
                $result = Replie::destroy($req->id);
            }else{
                $data = Report::
                    where('b_id',$req->id)
                    ->where('flg',0)
                    ->first();
                $result = Community::destroy($req->id);
            }
            // 조회된 값의 어드민플레그 1로 변경
            Log::debug('삭제완료');
            $data->admin_flg = "1";
            // 변경한 값 저장
            $data->save();
            // 저장
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
    // 게시글유지 플레그만 변경
    public function reportpost(Request $req){
        try {
            // 트랜잭션시작
            DB::beginTransaction();
            // 리퀘스트값으로 조회
            $data = Report::
                where('id',$req->id)
                ->first();
            // 플레그변경
            $data->admin_flg = $req->flg;
            // 변경한 값 저장
            $data->save();
            // 저장
            DB::commit();
            return response()->json([
                'code' => '0'
            ], 200);
        } catch(Exception $e){
            // 롤백
            DB::rollback();
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '변경실패 실패.'
            ], 400);
        }
    }
    // 유저조회
    public function userget(Request $req){
        $case = ['id','email'];
        $data = User::withTrashed()
            ->where($case[$req->flg],$req->val)
            ->orderby('id','desc')
            ->first();
        $result = Report::
            where('u_id',$data->id)
            ->orderby('restraint_at','desc')
            ->get();
        $data->cnt= $result->count();
        if($result->count() > 0){
            $data->res_at= $result->first()->restraint_at;
        }
        Log::debug($data);
        if(empty($data)){
            return response()->json([
                'code' => '1',
                'errorMsg' => '조회된 회원이 없습니다'
            ], 200);
        }else if(!empty($data)){
            return response()->json([
                'code' => '0',
                'data' =>  $data,
            ], 200);
        }else{
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '회원조회에 실패했습니다'
            ], 400);
        }
    }
    // 유저제재
    public function restraintuser(Request $req){
        try {
            $date =[1,3,7,15,30,36500];
            // 트랜잭션시작
            DB::beginTransaction();
            if($req->id){
                $data = Report::
                    where('id',$req->id)
                    ->first();
                $data->r_id = $req->u_id;
                $data->restraint = $req->msg;
                Log::debug($req->date);
                if ($req->date === "5") {
                    $data->restraint_at = Carbon::parse('9999-01-01 00:00:00');
                }else{
                    $data->restraint_at = date("Y-m-d H:i:s", strtotime("+".$date[$req->date]." days"));
                }  
                $data->save();
            }else{
                // 인서트할 데이터 추가
                $data['r_id'] = $req->u_id;
                $data['restraint'] = $req->msg;
                Log::debug($req->date);
                if ($req->date === "5") {
                    $data['restraint_at'] = Carbon::parse('9999-01-01 00:00:00');
                }else{
                    $data['restraint_at'] = date("Y-m-d H:i:s", strtotime("+".$date[$req->date]." days"));
                    Log::debug($data['restraint_at']);
                }
                // 처리결과를 인서트
                $data = Report::create($data);
            }
            // 저장
            DB::commit();
            return response()->json([
                'code' => '0'
            ], 200);
        } catch(Exception $e){
            // 롤백
            DB::rollback();
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '변경 실패.'
            ], 400);
        }
    }
    // 유저제재해제
    public function restraintreset(Request $req){
        try {
            // 트랜잭션시작
            DB::beginTransaction();
            // 리퀘스트온 아이디가 있을때
            if($req->id){
                $data = Report::
                where('id',$req->id)
                ->first();
                $data['restraint_at'] = null;
                // 변경한 값 저장
                $data->save();
            }else{
                $data = Report::
                where('u_id',$req->u_id)
                ->get();
                $data['restraint_at'] = null;
                // 변경한 값 저장
                $data->save();
            }
            // 저장
            DB::commit();
            return response()->json([
                'code' => '0'
            ], 200);
        } catch(Exception $e){
            // 롤백
            DB::rollback();
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '변경 실패.'
            ], 400);
        }
    }
    // 신고데이터 8개 가져오기
    public function reportall(Request $req){
        $data_before = Report::
            select('users.email','reports.*')
            ->join('users', 'reports.u_id', '=', 'users.id')
            ->where('reports.admin_flg', "0")
            ->orderby('reports.created_at','desc')
            ->limit(8)
            ->get();
        $data_before_cnt = Report::
            where('admin_flg', "0")
            ->count();
        $data_after = Report::
            select('users.email','reports.*')
            ->join('users', 'reports.u_id', '=', 'users.id')
            ->where('reports.admin_flg','!=', "0")
            ->orderby('reports.updated_at','desc')
            ->limit(8)
            ->get();
        $data_after_cnt = Report::
            where('admin_flg','!=', "0")
            ->count();
        return response()->json([
            'code' => '0',
            'data_before' => $data_before,
            'b_cnt' => $data_before,
            'data_after' => $data_after,
            'a_cnt' => $data_after,
        ], 200);
    }
    
    // 삭제된게시물 복구
    public function repairpost(Request $req){
        try {
            Log::debug($req->flg);
            // 트랜잭션시작
            DB::beginTransaction();
            if($req->flg==="0"){
                // 커뮤니티 게시글 조회
                $data = Community::withTrashed()
                    ->where('id',$req->id)
                    ->first();
                // 삭제일자 삭제
                $data->deleted_at = null;
                // 저장
                $data->save();
            }else if($req->flg==="1"){
                // 댓글 조회
                $data = Replie::withTrashed()
                    ->where('id',$req->id)
                    ->first();
                // 삭제일자 삭제
                $data->deleted_at = null;
                // 저장
                $data->save();
            }else{
                // 없을시
                Log::debug("없을때");
                return response()->json([
                    'code' => 'E99',
                    'errorMsg' => '변경 실패.'
                ], 400);
            }
            Log::debug("1차통과");
            // 플래그변경위해 신고테이블조회
            $result = Report::
                where('b_id',$req->id)
                ->where('flg',$req->flg)
                ->first();
            $result->admin_flg = 2;
            // 변경한 값 저장
            $result->save();
            // 저장
            Log::debug($result);
            DB::commit();
            return response()->json([
                'code' => '0'
            ], 200);
        } catch(Exception $e){
            // 롤백
            DB::rollback();
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '변경 실패.'
            ], 400);
        }
    }
    // 건의 8개씩 가져오기
    public function requestall(Request $req){
        $data_before = Community::
            select('users.email','community.*')
            ->where('community.flg', "3")
            ->where('community.admin_flg', "0")
            ->join('users', 'community.u_id', '=', 'users.id')
            ->orderby('community.created_at','desc')
            ->limit(8)
            ->get();
        $data_after = Community::
            select('users.email','community.*','replies.replie')
            ->where('community.flg', "3")
            ->where('community.admin_flg', "1")
            ->join('users', 'community.u_id', '=', 'users.id')
            ->join('replies', 'community.id', '=', 'replies.b_id')
            ->where('replies.flg', "1")
            ->orderby('community.updated_at','desc')
            ->limit(8)
            ->get();
        Log::debug($data_after);
        return response()->json([
            'code' => '0',
            'data_before' => $data_before,
            'data_after' => $data_after,
        ], 200);
    }
    // 답변변경 변경
    public function answerupdate(Request $req){
        try {
            // 트랜잭션시작
            DB::beginTransaction();
            // 리퀘스트값으로 조회
            $data = Replie::
                where('b_id',$req->id)
                ->where('flg','1')
                ->first();
            // 플레그변경
            $data->replie = $req->replie;
            // 변경한 값 저장
            $data->save();
            // 저장
            DB::commit();
            return response()->json([
                'code' => '0'
            ], 200);
        } catch(Exception $e){
            // 롤백
            DB::rollback();
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '변경실패 실패.'
            ], 400);
        }
    }
    // 특정시간에 동작
    public function test(Request $req){
        $schedule->call(function () {
            // 여기에 실행할 쿼리문을 작성
            \DB::statement('YOUR SQL QUERY HERE');
        })->when(function () {
            // 특정 날짜와 시간에만 실행되도록 설정
            $targetDateTime = '2024-01-15 15:30:00'; // 예시: 2024년 1월 15일 오후 3시 30분
            return now()->toDateTimeString() === $targetDateTime;
        });
    }
}
