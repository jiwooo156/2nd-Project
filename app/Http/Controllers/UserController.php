<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Del_Reason;
use App\Models\Authenticate;
use App\Models\Admin;
use App\Models\Community;
use App\Models\Replie;
use App\Models\Report;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller
{
    // 이메일중복확인
    // public function emailchk(Request $req)
    // {
    //     $result = User::select('email')->where('email',$req->email)->get();
    //     if($result){
    //         return response()->json([
    //             'code' => '0'
    //             ,'data' => $result
    //         ], 200);
    //     }else{

    //     }
    // }
    // 이메일중복확인기능 통합

    // 세션에 유저정보확인
    public function chkauth(Request $req)
    {   
        $result=Auth::check();
        $sessionExpiration = Auth::guard()->getSession()->get('userId');
        if($result){
            return response()->json([
                'code' => '0'
            ], 200);
        }else{
            return response()->json([
                'code' => '1'
            ], 200);
        }
    }
    public function nickchk(Request $req)
    {   
        // 유저정보 조회
        $result = User::select('nick')->where('nick',$req->nick)->get();
        if($result){
            return response()->json([
                'code' => '0'
                ,'data' => $result
            ], 200);
        }
    }

    // 회원가입
    public function store(Request $req)
    {
        // 리퀘스트 정보로 유저테이블 정보 조회
        $req_result = User::where('email',$req->email)->orwhere('nick',$req->nick)->first();
        // 쿠키를 이용해 인증테이블의 이메일 조회
        $auth_result = Authenticate::select('email')->where('id',$req->cookie('auth_id'))->get();
        // 유저테이블 리턴결과 있을때
        if($req_result){
            // 리퀘스트 이메일 값이 이미 유저테이블에 있을때
            if($req->email===$req_result->email){
                return response()->json([
                    'code' => 'E05',
                    'errorMsg' => '이미사용 중인 이메일 입니다.'
                ], 400);
            // 리퀘스트 닉네임 값이 이미 유저테이블에 있을대
            }else if($req->nick===$req_result->nick){
                return response()->json([
                    'code' => 'E05',
                    'errorMsg' => '이미 사용중인 닉네임 입니다.'
                ], 400);
            }else{
                return response()->json([
                    'code' => 'E99',
                    'errorMsg' => '회원가입 시도중 오류가 발생했습니다.'
                ], 400);
            }
        }else{
            // 리퀘스트온 값과 인증테이블의 이메일 값이 같을때
            if($req->email===$auth_result[0]->email){
                // 데이터중 필요한거만 선택
                $data = $req->only('email','name','password','birthdate','phone','gender','nick');
                // 암호화처리
                $data['password'] = Hash::make($data['password']);
                // 처리결과를 인서트
                $result = User::create($data);
                if($result){
                    $response = response()->json([
                        'code' => '0'
                        ,'data' => $result
                    ], 200);
                    return $response->cookie('auth_id', null, -1);
                }else{
                    return response()->json([
                        'code' => 'E05',
                        'errorMsg' => '회원가입에 실패했습니다.'
                    ], 400);
                }
            // 리퀘스트온 값과 인증테이블의 이메일 값이 다를때(인증받은 이메일이아닐때)
            }else{
                return response()->json([
                    'code' => 'E99',
                    'errorMsg' => '인증 받으신 이메일이 아닙니다.'
                ], 400);
            }
        }
    }

    // 로그인
    public function login(Request $req)
    {
        // 리퀘스트 정보로 유저테이블 정보 조회
        $result = User::where('email',$req->email)->first();
    
        // 조회된 값이 없을때
        if(!$result){
            $errorMsg = ['존재하지않는 이메일 입니다.'];
            return response()->json([
                'code' => 'E06'
                ,'errorMsg' => $errorMsg
            ], 400);
        }
        $admin_flg = Admin::where('u_id',$result->id)->first();
        // 관리자일떄만
        if($result&&$admin_flg){
            Log::debug("함수진입");
            Auth::login($result);
            Auth::user();
            return response()->json([
                'code' => '1'
                ,'data' => $result
            ], 200);
        // 값이 조회됬을때
        }else if($result){
            Log::debug("회원들오는곳");
            if(!(Hash::check($req->password, $result->password))){
                $errorMsg = ['비밀번호를 확인해주세요'];
                return response()->json([
                    'code' => 'E06'
                    ,'errorMsg' => $errorMsg
                ], 400);
            }
            Auth::login($result);
            Auth::user();
            return response()->json([
                'code' => '0',
                'data' => $result
            ], 200);
        // 그외 에러일시
        }else{
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '로그인 시도중 오류가 발생했습니다.'
            ], 400);
        }
            // $token = Str::random(100);
            // $result1 = 
            //     DB::table('users')
            //     ->where('email',$req->email)
            //     ->update([
            //         'access_token' =>  $token 
            //     ]);       
            // if(!$result1){
            //     DB::rollback();
            // }else(
            //     DB::commit()
            // );
            // $response = response()->json([
            //     'code' => '0',
            //     'data' => $result
            // ], 200);
            // return $response->cookie('access_token', $token, 1440)
            // ->cookie('nick', $result->nick, 1440, null, null, false, false);
            // 1211 최정훈 수정 쿠키사용x
    }
    // 로그아웃
    public function logout(Request $req){
        // Auth클레스에 정보삭제 ->세션에서 파기
        $result = Auth::logout();
        // 정상처리 됬을때
        return response()->json([
            'code' => '0'
        ], 200);
    }
    // 유저비밀번호 확인
    public function userchk(Request $req){
        // 세션에 유저정보 조회
        $auth = Auth::user();
        // 세션에 유저정보중 email 토대로 유저 테이블 조회
        $result = User::where('email',$auth->email)->first();
        // 리퀘스트 온 패스워드 값이 유저 테이블의 패스워드 값과 일치하지 않을 시
        if(!(Hash::check($req->password, $result->password))){
            $errorMsg = ["비밀번호가 일치하지 않습니다"];
            return response()->json([
                'code' => 'E07',
                'errorMsg' => $errorMsg
            ], 400);
        // 리퀘스트 온 패스워드 값이 유저 테이블의 패스워드 값과 일치할떄
        }else if((Hash::check($req->password, $result->password))){
            return response()->json([
                'code' => '0',
                'data' => $result
            ], 200);
        // 그외 사항시
        }else{
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '비밀번호 인증 시도중 에러발생.'
            ], 400);
        }
    }
    // 유저정보조회
    public function userinfo(Request $req){
        // 세션에 유저정보 조회
        $auth = Auth::user();
        // 세션에 유저정보중 email 토대로 유저 테이블에 아이디 이메일 닉네임 조회
        $result = User::select('id','email','nick')->where('email',$auth->email)->first();
        $admin = User::where('email',$auth->email)->first();
        // 조회된 유저정보 있을시
        if($result){
            return response()->json([
                'code' => '0',
                'data' => $result
            ], 200);
        // 그 외 오류일시
        }else{
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '비밀번호 인증 시도중 에러발생.'
            ], 400);
        }
    }
    // 비밀번호 변경
    public function changepw(Request $req){
        try {
            // 트랜잭션시작
            DB::beginTransaction();
            // 세션에 유저정보 조회
            $auth = Auth::user();
            // 리퀘스트 온 비밀번호 값 hash처리
            $newpw = Hash::make($req->password);
            // 세션에 유저정보중 email 토대로 유저 테이블에 조회
            $result = User::where('email',$auth->email)->first();
            // 조회된 값중 비밀번호 hash처리 한 비밀번호로 변경
            $result->password = $newpw;
            // 변경한 값 저장
            $result->save();
            // 저장
            DB::commit();
            return response()->json([
                'code' => '0',
                'data' => $result
            ], 200);
        } catch(Exception $e){
            // 롤백
            DB::rollback();
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '비밀번호 인증 시도중 에러발생.'
            ], 400);
        }
    }
    // 닉네임변경
    public function changenick(Request $req){
        // 리퀘스트 정보로 유저테이블 정보 조회
        $result = User::where('nick',$req->nick)->first();
        // // 악성 유저 대응용
        // if($result){
        //     if($req->nick===$result->nick){
        //         return response()->json([
        //             'code' => 'E05',
        //             'errorMsg' => '중복된 닉네임 입니다.'
        //         ], 400);
        //     }else{
        //         return response()->json([
        //             'code' => 'E05',
        //             'errorMsg' => '오류발생.'
        //         ], 400);
        //     }
        // }else{
        // 1222 수정 최정훈 실시간 닉네임 확인이라 이상한값 전송 불가
        try {
            // 트랜잭션시작
            DB::beginTransaction();
            // 세션에 유저정보 조회
            $auth = Auth::user();
            // 세션에 유저정보중 email 토대로 유저 테이블에 조회
            $result = User::where('email',$auth->email)->first();
            // 리퀘스트 온 닉네임값으로 변경
            $result->nick = $req->nick;
            // 변경한 값 저장
            $result->save();
            // 저장
            DB::commit();
            return response()->json([
                'code' => '0',
                'data' => $result
            ], 200);
        } catch(Exception $e){
            DB::rollback();
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '닉네임 변경에 실패하였습니다.'
            ], 400);
        }
    }
    // 회원탈퇴
    public function deluser(Request $req){
        try {
            // 트랜잭션시작
            DB::beginTransaction();
            // 세션에 유저정보 조회
            $auth = Auth::user();
            // 세션에 유저정보중 email 토대로 유저 테이블에 조회
            $result = User::where('email',$auth->email)->first();
            // 유저정보 삭제(소프트딜리트)
            User::destroy($result->id);
            // data[]에 유저아이디 저장
            $data['u_id'] = $result->id;
            // data[]에 유저삭제플레그 저장 저장
            $data['del_flg'] = $req->del_flg;
            
            // 리퀘스트 온 삭제플레그가 0일시
            if($req->del_flg==="0"){
                // data[]에 리퀘스트 온 삭제 메세지 저장
                $data['del_self_msg'] = $req->del_msg;
            }
            // 삭제사유테이블에 data정보 인서트
            $result1 = Del_Reason::create($data);
            // 저장
            DB::commit();
            // 삭제사유 저장결과 및 유저삭제 정상처리 시
            if($result1&&$result){
                return response()->json([
                    'code' => '0'
                ], 200);
            // 비정상처리
            }else{
                return response()->json([
                    'code' => 'E99',
                    'errorMsg' => '회원탈퇴중 오류가 발생했습니다'
                ], 400);
            }
        // 처리오류시
        } catch(Exception $e){
            // 롤백
            DB::rollback();
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '회원탈퇴중 오류가 발생했습니다'
            ], 400);
        }
    }
    // 이메일전송
    // public function sendemailauth(Request $req){
    //     $check_user = User::select('email')->where('email',$req->email)->get();
    //     if(count($check_user)===0){
    //         // 랜덤한 값 생성
    //         $uuid = Str::uuid();
    //         $db_data['email'] = $req->email;
    //         $db_data['auth_token'] = $uuid;
    //         $result = Authenticate::where('email',$req->email)->get();
    //         if(count($result) < 1){
    //             Log::debug("없을때");
    //             $total_result = Authenticate::create($db_data);
    //             $data['url'] = 'http://127.0.0.1:8000/signinchk?auth_token='.$uuid;
    //             Mail::send('mail.mail_form', ['data' => $data], function($message) use ($data, $req){
    //                 $message->to($req->email)->subject('이의이승페이지 이메일인증');
    //                 $message->from('dldmldltmd@gmail.com');
    //             });
    //             return response()->json([
    //                 'code' => '0'
    //             ], 200);
    //         }
    //         if(count($result)===1&&$result[0]->auth_flg==="0"&&$result[0]->auth_end > date("Y-m-d H:i:s")){
    //             Log::debug("과거");
    //             return response()->json([
    //                 'code' => 'E12',
    //                 'errorMsg' => '이미 인증을 위한 메일이 발송되었습니다'
    //             ], 200);
    //         }else if(count($result)===1&&$result[0]->auth_flg==="0"&&$result[0]->auth_end < date("Y-m-d H:i:s")){
    //             Log::debug("미래");
    //             try {
    //                 DB::beginTransaction();
    //                 $result[0]->auth_end = date("Y-m-d H:i:s", strtotime("+5 minutes"));
    //                 $result[0]->auth_token = $uuid;
    //                 $result[0]->save();
    //                 Log::debug("바뀜");
    //                 Log::debug($result[0]->auth_end);
    //                 DB::commit();
    //                 $data['url'] = 'http://127.0.0.1:8000/signinchk?auth_token='.$uuid;
    //                 Mail::send('mail.mail_form', ['data' => $data], function($message) use ($data, $req){
    //                     $message->to($req->email)->subject('이의이승페이지 이메일인증');
    //                     $message->from('dldmldltmd@gmail.com');
    //                 });
    //                 return response()->json([
    //                     'code' => '0'
    //                 ], 200); 
    //             } catch(Exception $e){
    //                 DB::rollback();
    //                 return response()->json([
    //                     'code' => 'E09',
    //                     'errorMsg' => '이메일 전송 중 오류가 발생했습니다'
    //                 ], 400);
    //             }
    //         }else if($result[0]->auth_flg==="1"){
    //             Log::debug("이미한사람");
    //             // 이미 이메일 인증이 된사람일 경우
    //             // 방법1
    //             try {
    //                 DB::beginTransaction();
    //                 $result[0]->auth_flg = "0";
    //                 $result[0]->auth_end = date("Y-m-d H:i:s", strtotime("+5 minutes"));
    //                 $result[0]->auth_token = $uuid;
    //                 $result[0]->save();
    //                 Log::debug("바뀜");
    //                 Log::debug($result[0]->auth_end);
    //                 DB::commit();
    //                 $data['url'] = 'http://127.0.0.1:8000/signinchk?auth_token='.$uuid;
    //                 Mail::send('mail.mail_form', ['data' => $data], function($message) use ($data, $req){
    //                     $message->to($req->email)->subject('이의이승페이지 이메일인증');
    //                     $message->from('dldmldltmd@gmail.com');
    //                 });
    //                 return response()->json([
    //                     'code' => '0'
    //                 ], 200); 
    //             } catch(Exception $e){
    //                 DB::rollback();
    //                 return response()->json([
    //                     'code' => 'E09',
    //                     'errorMsg' => '이메일 전송 중 오류가 발생했습니다'
    //                 ], 400);
    //             }
    //         }
    //     }else if(count($check_user)>0){
    //         return response()->json([
    //             'code' => 'E05',
    //             'errorMsg' => ['errorMsg'=>['이미 사용중인 이메일 입니다']]
    //         ], 400);
    //     }
    // }
    // 1218 수정 최정훈 기존방식 버리고 멘토님 피드백으로 변경

    // 이메일 인증후 전송
    public function sendemailauth(Request $req){
        // 리퀘스트온 이메일로 유저테이블 값 조회
        $check_user = User::select('email')->where('email',$req->email)->get();
        // 첫번쨰 통과 조건(유저테이블에 해당이메일이 없을때)
        if(count($check_user)===0){
            // 랜덤한 값 생성
            $uuid = Str::uuid();
            // $db_data[] 에 리퀘스트온 이메일값 저장
            $db_data['email'] = $req->email;
            // $db_data[] 에 생성한 토큰 저장
            $db_data['auth_token'] = $uuid;
            // 리퀘스트온 이메일값과 같으면서 인증발송시간이 10분이내인 인증테이블 정보 조회
            $mail_cnt = Authenticate::
                where('email',$req->email)
                ->where('auth_start','>',date("Y-m-d H:i:s", strtotime("-10 minutes")))
                ->get();
            // 두번째(유저테이블에 10분이내에 인증메일을 3회이하일때)
            if(count($mail_cnt)<3){
                // 인증 테이블에 $db_data[]값 인서트 
                Authenticate::create($db_data);
                // $db_data[] 에 url값 저장
                
                // 서버베포전
                // $data['url'] = 'http://127.0.0.1:8000/signinchk?auth_token='.$uuid;
                // 서버베포후
                $data['url'] = 'http://112.222.157.156:6005/signinchk?auth_token='.$uuid;
                
                // 메일발송 보내기
                Mail::send('mail.mail_form', ['data' => $data], function($message) use ($data, $req){
                    $message->to($req->email)->subject('이의이승페이지 이메일인증');
                    $message->from('dldmldltmd@gmail.com');
                });
                return response()->json([
                    'code' => '0'
                ], 200);
            // 유저테이블에 10분이내에 인증메일을 3회이하일때
            }else if(count($mail_cnt)>=3){
                return response()->json([
                    'code' => 'E13',
                    'errorMsg' => '10분이내 최대 3번 이메일 인증이 가능합니다. 잠시 후 다시 시도해 주세요'
                ], 200);
            }else{
                return response()->json([
                    'code' => 'E99',
                    'errorMsg' => '이메일 인증중 오류가 발생했습니다'
                ], 200);
            }
        }else if(count($check_user)>0){
            return response()->json([
                'code' => 'E05',
                'errorMsg' => ['errorMsg'=>['이미 사용중인 이메일 입니다']]
            ], 400);
        }else{
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '이메일 중복확인 중 오류가 발생했습니다'
            ], 200);
        }
    }
    // 이메일인증 url클릭시
    public function tokenchk(Request $req){
        // 리퀘스트온 토큰값과일치하고 인증가능 시간이 남았을때 인증테이블 데이터 조회
        $email_get_result = Authenticate::where('auth_token', $req->auth_token)
                ->where('auth_end', '>', now())
                ->first();
        // 조회 된 값이 없을시
        if(!($email_get_result)){
            $err = "인증이 만료되었거나 잘못된 URL입니다."."\n"."기존페이지로 돌아가 인증을 다시 받아주세요";      
            return $err;
        }
        // 위 결과값에 이메일로 조회하며 pk내림차순으로 첫번째값을 인증테이블에서 조회(가장최신값)
        $result = Authenticate::where('email',$email_get_result->email)
                ->orderBy('id', 'desc')
                ->first();
        // 가장최신 토큰과 유저가 보낸 토큰이 일치할시
        if($result->auth_token===$req->auth_token){
            try {
                // 트랜잭션시작
                DB::beginTransaction();
                // 인증플레그 1로 변경
                $result->auth_flg = "1";
                // 저장
                $result->save();
                DB::commit();    
                // 리다이렉트 처리 후 쿠키생성
                return redirect('/signin')->cookie('auth_id', $result->id, 720, null, null, false, false);
            // 실패시
            } catch(Exception $e){
                DB::rollback();
                $err = "인증에 실패하였습니다."."\n"."기존페이지로 돌아가 다시 인증을 받아주세요";      
                return $err;
            }
        // 일치하지않거나 시간이 지나거나 잘못된처리일시
        }else{
            $err = "인증이 만료된 URL입니다."."\n"."기존페이지로 돌아가 다시 인증을 받아주세요";      
            return $err;
        }
    }
    // 이메일가져오기
    public function emailload(Request $req)
    {
        // 쿠키에 담긴 유저아이디 로 이메일조회
        $result = Authenticate::select('email')->where('id',$req->cookie('auth_id'))->get();

        // 값이 있을시
        if(count($result)===1){
            return response()->json([
                'code' => '0'
                ,'data' => $result[0]
            ], 200);
        // 값이 없을시
        }else{
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '이메일을 가져오던 중 오류가 발생했습니다'
            ], 200);
        }
    }
    // 인증시간연장
    public function addtime(Request $req)
    {   
        // 리퀘스트온 이메일 값으로 아이디 역순 조회
        $result = Authenticate::
            where('email', $req->email)
            ->orderBy('id', 'desc')
            ->first();
        // 조회된 값이있을시
        if($result){
            try {
                // 트랜 잭션 시작
                DB::beginTransaction();
                // 인증만료시간 5분뒤로변경
                $result->auth_end = date("Y-m-d H:i:s", strtotime("+5 minutes"));
                // 저장
                $result->save();
                DB::commit();
                return response()->json([
                    'code' => '0'
                ], 200); 
            // 실패시
            } catch(Exception $e){
                // 롤백
                DB::rollback();
                return response()->json([
                    'code' => 'E99',
                    'errorMsg' => '시간연장중 오류가 발생했습니다'
                ], 400);
            }
        // 조회된값이 없을시
        }else{
            return response()->json([
                'code' => 'E99',
                'errorMsg' => '시간연장을 위해 조회중 오류가 발생했습니다'
            ], 400);
        }
    }
        // 인증메일 재발송
    // public function resendemailauth(Request $req)
    // {
    //     $uuid = Str::uuid();
    //     $mail_cnt = Authenticate::
    //         where('email',$req->email)
    //         ->where('auth_start','>',date("Y-m-d H:i:s", strtotime("-10 minutes")))
    //         ->get();
    //         // 두번째(유저테이블에 10분이내에 인증메일을 3회이상 보냈을때)
    //     Log::debug(count($mail_cnt)<=3);
    //     if(count($mail_cnt)<=3){
    //         Log::debug("3개이하일때");
    //         Authenticate::create($db_data);
    //         $data['url'] = 'http://127.0.0.1:8000/signinchk?auth_token='.$uuid;
    //         Mail::send('mail.mail_form', ['data' => $data], function($message) use ($data, $req){
    //             $message->to($req->email)->subject('이의이승페이지 이메일인증');
    //             $message->from('dldmldltmd@gmail.com');
    //         });
    //         return response()->json([
    //             'code' => '0'
    //         ], 200);
    //     }else{
    //         Log::debug("3개이상일때");
    //         return response()->json([
    //             'code' => 'E13',
    //             'errorMsg' => '10분이내 최대 3번 이메일 인증이 가능합니다. 잠시 후 다시 시도해 주세요'
    //         ], 200);
    //     }
    // }

    // 어드민페이지 시작
    public function adminchk(Request $req)
    {
        Auth::user();
        $chk = Admin::where('u_id',Auth::user()->id)->get();
        if($req->id==Auth::user()->id && $req->nick === Auth::user()->nick && $req->email === Auth::user()->email && count($chk)>0){
            // 오늘 탈퇴자수
            // withTrashed = 소프트딜리트 된 애도 포함
            $out = User::withTrashed()
            ->where('deleted_at', '>=', $req->today)
            ->count();
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
            ->get();
            Log::debug($data);
            // 신고목록
            $report = Report::
            select('users.email','reports.*')
            ->where('reports.admin_flg', 0)
            ->join('users', 'reports.u_id', '=', 'users.id')
            ->orderby('reports.created_at','asc')
            ->get();
            return response()->json([
                'code' => '0',
                'sign_cnt' => $in,
                'drop_cnt' => $out,
                'data' => $data,
                'r_data' => $report
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
        if($req->flg==="커뮤"){
            Log::debug("보드일때");
            $data = Community::withTrashed()
            ->select('users.email','community.*')
            ->join('users', 'community.u_id', '=', 'users.id')
            ->where('community.id',$req->b_id)
            ->first();
        }else{
            Log::debug("댓글일떄");
            $data = Replie::withTrashed()
            ->select('users.email','replies.*')
            ->where('replies.id',$req->b_id)
            ->join('users', 'replies.u_id', '=', 'users.id')
            ->first();
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
            if($req->flg==="댓글"){
                Log::debug("댓글");
                $data = Report::
                    where('b_id',$req->id)
                    ->where('flg',1)
                    ->first();
                Log::debug( $data);
                $result = Replie::destroy($req->id);
            }else{
                Log::debug("커뮤");
                $data = Report::
                    where('b_id',$req->id)
                    ->where('flg',0)
                    ->first();
                Log::debug( $data);
                $result = Community::destroy($req->id);
            }
            // 삭제 정상시
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
            // 삭제 정상시
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
                'errorMsg' => '변경실패 실패.'
            ], 400);
        }
    }
}
