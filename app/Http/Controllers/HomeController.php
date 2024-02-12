<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
//    public function __invoke(Request $request)
//    {
//        return view('welcome');
//    }

    public function __invoke(Request $request)
    {

        $articles = Article::with('user')
            ->withCount('comments')
            ->withExists(['comments as recent_comments_exists'=>function($query){
                $query->where('created_at', '>', Carbon::now()->subDay());        }]) // 조건에 맞는 댓글을 찾기 subHour subDay 기준
                /* 팔로우하는 유저 + 나의 유저 글 가져오기 */
                ->when(Auth::check(), function($query){
                    $query->whereHas('user', function(Builder $query){
                       $query->whereIn('id', Auth::user()->followings->pluck('id')->push(Auth::id()));
                    });
            }) // 조건적 where 절 - 연관관계의 존재확인 쿼리 질의
            ->latest() // orderby created_at desc 와 같습니다
            ->paginate(); // 페이지네이션 처리 지원


        return view('articles.index',
        [
            'articles_name' => $articles,
        ]);
    }
}
