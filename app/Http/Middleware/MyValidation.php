<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// 로그찍히는 기능
use Illuminate\Support\Facades\Log;

class MyValidation
{
    // 미들웨어 생성 명령어
    // php artisan make:middleware 미들웨어명
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        Log::debug("******************유저 유효성체크 시작******************");   
        
        // 항목 리스트 
        $arrBaseKey = [
            'email'
            ,'name'
            ,'password'
            ,'pw_chk'
            ,'phone'
            ,'gender' 
            ,'birthdate' 
            ,'nick'
            ,'del_flg'
            ,'del_msg'
            ,'nick'
            ,'title'
            ,'content'
            ,'img'
        ];
        // 유효성 체크 리스트
        $arrBaseValidation = [
            'email' => 'required|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ,'name'     => 'required|regex:/^[가-힣]+$/u|min:2|max:10'
            ,'password' => 'required|regex:/^(?=.*[a-z])(?=.*\d)(?=.*[~!@#?])[a-zA-Z\d~!@#?]{8,20}$/u'
            ,'pw_chk' => 'same:password'
            ,'phone' => 'required|regex:/^010([0-9]{4})([0-9]{4})$/u'
            ,'gender' => 'required|in:M,F'
            ,'birthdate' => [
                'required',
                'regex:/^(19\d\d|20[0-2]\d)(0[1-9]|1[0-2])(0[1-9]|[12][0-9]|3[01])$/',
                'date_format:Ymd',
                'before_or_equal:' . now()->format('Ymd'),
            ]
            ,'del_flg' => 'required|in:0,1,2,3,4,5,6,7,8,9'
            ,'del_msg' => 'required|max:50|not_regex:/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/u'
            ,'nick' => 'required|regex:/^[a-zA-Z가-힣0-9]{2,8}$/u'
            ,'title' => 'required|max:100|not_regex:/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/u'
            ,'content' => 'required|max:1000|not_regex:/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/u'
            ,'img' => 'required|image|mimes:jpeg,png,jpg,gif'
        ];

        // request 파라미터
        $arrRequestParam=[];
        foreach($arrBaseKey as $val){
            if($request->has($val)){
                $arrRequestParam[$val] = $request->$val;
            } else {
                unset($arrBaseValidation[$val]);
            } 
        }
        Log::debug("리퀘스트 파라미터 획득",$arrRequestParam);     
        Log::debug("유효성 체크 리스트 획득",$arrBaseValidation);    

         // 유효성 검사
        $validator = Validator::make($arrRequestParam,$arrBaseValidation);

        // 유효성 검사 실패시 처리
        if($validator->fails()){
            Log::debug('fails', $validator->errors()->toArray());
            return response()->json([
                'code' => 'E03'
                ,'errorMsg' => $validator->errors()
            ], 300);
        }
        Log::debug("******************유저 유효성체크 종료******************");    
        return $next($request);
    }
}
