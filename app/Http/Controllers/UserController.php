<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Del_Reason;
use App\Models\Authenticate;
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

    // 닉네임중복확인
    public function nickchk(Request $req)
    {
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
        Log::debug("함수진입");
        $result = User::where('email',$req->email)->orwhere('nick',$req->nick)->first();
        // 악성 유저 대응용
        $req->cookie('auth_id');
        $result1 = Authenticate::select('email')->where('id',$req->cookie('auth_id'))->get();
        Log::debug("result1 = ".$result1);
        if($result){
            if($req->email===$result->email){
                Log::debug("이미사용중이메일 = ");
                return response()->json([
                    'code' => 'E05',
                    'errorMsg' => '이미사용 중인 이메일 입니다.'
                ], 400);
            }else if($req->nick===$result->nick){
                Log::debug("이미사용중닉 = ");
                return response()->json([
                    'code' => 'E05',
                    'errorMsg' => '이미 사용중인 닉네임 입니다.'
                ], 400);
            }
        }else{
            Log::debug("정상처리 1단계");
            if($req->email===$result1[0]->email){
                Log::debug("리퀘스트랑 리져트안에 이메일 같은지");
                $data = $req->only('email','name','password','birthdate','phone','gender','nick');
                $data['password'] = Hash::make($data['password']);
                $result = User::create($data);
                if($result){
                    Log::debug("같으면서 정상일때");
                    $response = response()->json([
                        'code' => '0'
                        ,'data' => $result
                    ], 200);
                    return $response->cookie('auth_id', null, -1);
                }else{
                    Log::debug("같은대 비정상처리");
                    return response()->json([
                        'code' => 'E05',
                        'errorMsg' => '회원가입에 실패했습니다.'
                    ], 400);
                }
            }else{
                Log::debug("다를때");
                return response()->json([
                    'code' => 'E05',
                    'errorMsg' => '오류발생.'
                ], 400);
            }
        }
    }

    // 로그인
    public function login(Request $req)
    {
        $result = User::where('email',$req->email)->first();
        if(!$result){
            $errorMsg = ['존재하지않는 이메일 입니다.'];
            return response()->json([
                'code' => 'E06'
                ,'errorMsg' => $errorMsg
            ], 400);
        }else if(!(Hash::check($req->password, $result->password))){
            $errorMsg = ['비밀번호를 확인해주세요'];
            return response()->json([
                'code' => 'E06'
                ,'errorMsg' => $errorMsg
            ], 400);
        }
        if($result){
            Auth::login($result);
            Auth::user();
            return response()->json([
                'code' => '0',
                'data' => $result
            ], 200);
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
    }
    // 로그아웃
    public function logout(Request $req){
        $result = Auth::logout();
        Log::debug($result);
        return response()->json([
            'code' => '0',
            'data' => $result
        ], 200);
    }
    // 유저비밀번호 확인
    public function userchk(Request $req){
        $auth = Auth::user();
        $result = User::where('email',$auth->email)->first();
        if(!(Hash::check($req->password, $result->password))){
            Log::debug("비밀번호 미일치");
            $errorMsg = ["비밀번호가 일치하지 않습니다"];
            return response()->json([
                'code' => 'E07',
                'errorMsg' => $errorMsg
            ], 400);
        }
        if($result){
            Log::debug("비밀번호 일치");
            return response()->json([
                'code' => '0',
                'data' => $result
            ], 200);
        }
    }
    // 유저정보조회
    public function userinfo(Request $req){
        $auth = Auth::user();
        $result = User::select('id','email','nick')->where('email',$auth->email)->first();
        Log::debug($result);
        return response()->json([
            'code' => '0',
            'data' => $result
        ], 200);
    }
    // 비밀번호 변경
    public function changepw(Request $req){
        try {
            DB::beginTransaction();
            $auth = Auth::user();
            Log::debug($req->password);
            $newpw = Hash::make($req->password);
            Log::debug($newpw);
            $result = User::where('email',$auth->email)->first();
            $result->password = $newpw;
            $result->save();
            DB::commit();
            return response()->json([
                'code' => '0',
                'data' => $result
            ], 200);
        } catch(Exception $e){
            DB::rollback();
            return response()->json([
                'code' => 'E08',
                'errorMsg' => ["비밀번호 변경에 실패했습니다"]
            ], 400);
        }
    }
    // 닉네임변경
    public function changenick(Request $req){
        $result = User::where('nick',$req->nick)->first();
        // 악성 유저 대응용
        Log::debug($result);
        if($result){
            if($req->nick===$result->nick){
                return response()->json([
                    'code' => 'E05',
                    'errorMsg' => '중복된 닉네임 입니다.'
                ], 400);
            }else{
                return response()->json([
                    'code' => 'E05',
                    'errorMsg' => '오류발생.'
                ], 400);
            }
        }else{
            try {
                DB::beginTransaction();
                $auth = Auth::user();
                $result = User::where('email',$auth->email)->first();
                $result->nick = $req->nick;
                $result->save();
                DB::commit();
                return response()->json([
                    'code' => '0',
                    'data' => $result
                ], 200);
            } catch(Exception $e){
                DB::rollback();
                return response()->json([
                    'code' => 'E09',
                    'errorMsg' => ["닉네임 변경에 실패했습니다"]
                ], 400);
            }
        }
    }
    // 회원탈퇴
    public function deluser(Request $req){
        try {
            DB::beginTransaction();
            $auth = Auth::user();
            $result = User::where('email',$auth->email)->first();
            User::destroy($result->id);
            $data['u_id'] = $result->id;
            Log::debug($result->id);
            $data['del_flg'] = $req->del_flg;
            Log::debug($req->del_flg);
            if($req->del_flg==="0"){
                $data['del_self_msg'] = $req->del_msg;
            }
            $result1 = Del_Reason::create($data);
            DB::commit();
            if($result1&&$result){
                return response()->json([
                    'code' => '0'
                ], 200);
            }else{
                return response()->json([
                    'code' => 'E05',
                    'errorMsg' => ['회원탈퇴중 오류가 발생했습니다']
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
        $check_user = User::select('email')->where('email',$req->email)->get();
        // 첫번쨰 통과 조건(유저테이블에 해당이메일이 없을때)
        if(count($check_user)===0){
            // 랜덤한 값 생성
            $uuid = Str::uuid();
            $db_data['email'] = $req->email;
            $db_data['auth_token'] = $uuid;
            $mail_cnt = Authenticate::
                where('email',$req->email)
                ->where('auth_start','>',date("Y-m-d H:i:s", strtotime("-10 minutes")))
                ->get();
            // 두번째(유저테이블에 10분이내에 인증메일을 3회이상 보냈을때)
            if(count($mail_cnt)<3){
                Authenticate::create($db_data);
                Log::debug("3개이하일때");
                $data['url'] = 'http://127.0.0.1:8000/signinchk?auth_token='.$uuid;
                Mail::send('mail.mail_form', ['data' => $data], function($message) use ($data, $req){
                    $message->to($req->email)->subject('이의이승페이지 이메일인증');
                    $message->from('dldmldltmd@gmail.com');
                });
                return response()->json([
                    'code' => '0'
                ], 200);
            }else{
                Log::debug("3개이상");
                return response()->json([
                    'code' => 'E13',
                    'errorMsg' => '10분이내 최대 3번 이메일 인증이 가능합니다. 잠시 후 다시 시도해 주세요'
                ], 200);
            }
        }else if(count($check_user)>0){
            return response()->json([
                'code' => 'E05',
                'errorMsg' => ['errorMsg'=>['이미 사용중인 이메일 입니다']]
            ], 400);
        }
    }
    // 이메일인증 url클릭시
    public function tokenchk(Request $req){
        Log::debug("진입");
        $email_get_result = Authenticate::where('auth_token', $req->auth_token)
                ->where('auth_end', '>', now())
                ->first();
        // 1차 오류잡기(url에 토큰으로 조회)
        if(!($email_get_result)){
            $err = "인증이 만료되었거나 잘못된 URL입니다."."\n"."기존페이지로 돌아가 인증을 다시 받아주세요";      
            return $err;
        }
        $result = Authenticate::where('email',$email_get_result->email)
                ->orderBy('id', 'desc')
                ->first();
        // 1차 오류잡기
        if($result->auth_token===$req->auth_token){
            try {
                DB::beginTransaction();
                Log::debug("트랜잭션시작");
                $result->auth_flg = "1";
                $result->save();
                DB::commit();    
                Log::debug("커밋완료");
                return redirect('/signin')->cookie('auth_id', $result->id, 720, null, null, false, false);
            } catch(Exception $e){
                DB::rollback();
                $err = "인증에 실패하였습니다."."\n"."기존페이지로 돌아가 다시 인증을 받아주세요";      
                return $err;
            }
        }else{
            $err = "인증이 만료된 URL입니다."."\n"."기존페이지로 돌아가 다시 인증을 받아주세요";      
            return $err;
        }
    }
    // 이메일가져오기
    public function emailload(Request $req)
    {
        $req->cookie('auth_id');
        Log::debug($req->cookie('auth_id'));
        $result = Authenticate::select('email')->where('id',$req->cookie('auth_id'))->get();
        if(count($result)>0){
            return response()->json([
                'code' => '0'
                ,'data' => $result[0]
            ], 200);
        }else{
            return response()->json([
                'code' => 'E15'
                ,'errorMsg' => '오류가 발생했습니다. 다시한번 확인해주세요'
            ], 200);
        }
    }
    // 인증시간연장
    public function addtime(Request $req)
    {
        $result = Authenticate::
            where('email', $req->email)
            ->orderBy('id', 'desc')
            ->first();
        if($result){
            try {
                DB::beginTransaction();
                $result->auth_end = date("Y-m-d H:i:s", strtotime("+5 minutes"));
                $result->save();
                Log::debug($result);
                Log::debug($result->auth_end);
                DB::commit();
                return response()->json([
                    'code' => '0'
                ], 200); 
            } catch(Exception $e){
                DB::rollback();
                return response()->json([
                    'code' => 'E09',
                    'errorMsg' => '시간연장중 오류가 발생했습니다'
                ], 400);
            }
        }else{
            return response()->json([
                'code' => 'E09',
                'errorMsg' => '문제발생'
            ], 400);
        }
    }
    // // 인증메일 재발송
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
}
