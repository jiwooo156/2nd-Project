<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


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
            $token = Str::random(100);
            $result1 = 
                DB::table('users')
                ->where('email',$req->email)
                ->update([
                    'access_token' =>  $token 
                ]);       
            if(!$result1){
                DB::rollback();
            }else(
                DB::commit()
            );
            $response = response()->json([
                'code' => '0',
                'data' => $result
            ], 200);
            Log::debug($result);
            return $response->cookie('access_token', $token, 1440)
            ->cookie('nick', $result->nick, 1440, null, null, false, false);
        }
    }
    // 로그아웃
    public function logout(Request $req){
        $token = $req->cookie('access_token');
        $nick = $req->nick;
        Log::debug($token);
        Log::debug($nick);
        $result = User::where('nick',$nick)
                    ->where('access_token',$token)
                    ->get();
        if($result){
            $response->cookie('access_token', null, -1);
            $response->cookie('nick', null, -1);

            return response()->json([
                'code' => '0'
                ,'data' => $result
            ], 200);
        }else{
            return response()->json([
                'code' => 'E90'
                ,'errorMsg' => $errorMsg
            ], 400);
        }
    
    }
}
