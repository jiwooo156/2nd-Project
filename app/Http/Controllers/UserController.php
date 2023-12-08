<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
// use Illuminate\Http\Response;


class UserController extends Controller
{
    public function emailchk(Request $req)
    {
        // get이라서 여기서 진행
        Log::debug("이메일체크진입");
        // 바리데이션 통과시
        $result = User::select('email')->where('email',$req->email)->get();

        return response()->json([
            'code' => '0'
            ,'data' => $result
        ], 200);
    }

    public function nickchk(Request $req)
    {
        Log::debug("이메일체크진입");
        // 바리데이션 통과시
        $result = User::select('nick')->where('nick',$req->nick)->get();

        return response()->json([
            'code' => '0'
            ,'data' => $result
        ], 200);
    }

    
    public function store(Request $req)
    {
        $data = $req->only('email','name','password','birthdate','phone','gender','nick');
        // 비밀번호 암호화
        $data['password'] = Hash::make($data['password']);
        $token = Str::random(100);
        $data['access_token'] = $token;
        // 회원 정보 DB에 저장
        // orm,엘로컨트 방식
        $result = User::create($data);
        if($result){
            response()->cookie('access_token', $token, 1440);
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
