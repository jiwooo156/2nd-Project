<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    // 이메일중복확인
    public function emailchk(Request $req)
    {
        $result = User::select('email')->where('email',$req->email)->get();
        return response()->json([
            'code' => '0'
            ,'data' => $result
        ], 200);
    }

    // 닉네임중복확인
    public function nickchk(Request $req)
    {
        $result = User::select('nick')->where('nick',$req->nick)->get();
        return response()->json([
            'code' => '0'
            ,'data' => $result
        ], 200);
    }

    // 회원가입
    public function store(Request $req)
    {
        $result = User::where('email',$req->email)->orwhere('nick',$req->nick)->first();
        // 악성 유저 대응용
        if($result){
            if($req->email===$result->email){
                return response()->json([
                    'code' => 'E05',
                    'errorMsg' => '중복된 이메일 입니다.'
                ], 400);
            }else if($req->nick===$result->nick){
                return response()->json([
                    'code' => 'E05',
                    'errorMsg' => '중복된 닉네임 입니다.'
                ], 400);
            }
        }else{
            $data = $req->only('email','name','password','birthdate','phone','gender','nick');
            $data['password'] = Hash::make($data['password']);
            $result = User::create($data);
            if($result){
                return response()->json([
                    'code' => '0'
                    ,'data' => $result
                ], 200);
            }else{
                return response()->json([
                    'code' => 'E05',
                    'errorMsg' => '회원가입에 실패했습니다.'
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
            $errorMsg = ["비밀번호가 일치하지 않습니다"];
            return response()->json([
                'code' => 'E07',
                'errorMsg' => $errorMsg
            ], 400);
        }
        if($result){
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
    public function deluser(Request $req){
        try {
            DB::beginTransaction();
            $auth = Auth::user();
            $result = User::where('email',$auth->email)->first();
            $result->del_flg = $req->del_flg;
            $result->del_msg = $req->del_msg;
            $result->save();
            Log::debug($result->id);
            User::destroy($result->id);
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
