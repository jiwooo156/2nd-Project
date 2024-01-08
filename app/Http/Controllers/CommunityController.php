<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Community;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommunityController extends Controller
{
    // 질문&건의 게시글 조회
    public function getQnaList(Request $req) {
        Log::debug("함수진입");
        // 질문 게시글 조회
        $qnaList = Community::where('flg', '=', '2')
        ->orderby('created_at','desc')
        ->get();
        Log::debug("질문 게시글 리스트 = ".$qnaList);
        // 질문 게시글 조회
        $tendinousList = Community::where('flg', '=', '3')
        ->orderby('created_at','desc')
        ->get();
        Log::debug("건의 게시글 리스트 = ".$tendinousList);
        return response()->json([
            'code' => '0',
            'qnaList' => $qnaList,
            'tendinousList' => $tendinousList,
        ], 200);
    }
}
