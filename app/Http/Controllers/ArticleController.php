<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\DeleteArticleRequest;
use App\Http\Requests\EditArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Article;


class ArticleController extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth');
//         $this->middleware('auth')->only('index', 'show'); // index, show 만 접근 가능
        $this->middleware('auth')->except(['index', 'show']); // index, show 만 접근 가능

    }

    //
    public function create(){
        return view('articles/create');
    }

    public function store(CreateArticleRequest $request){
        /* DB 파사드 방식 */
        $input = $request->validated();

        // DB 파사드를 이용하는 방법
        // DB::insert("INSERT INTO articles (body, user_id) VALUES (:body, :userId)", ['body' => $input['body'], 'userId' => Auth::id()]);

        // 쿼리 빌더를 사용하는 방법
        /*DB::table('articles')->insert([
            'body' => $input['body'],
            'user_id' => Auth::id(),
        ]);*/

        // 엘로퀀트 ORM 사용방법 (엘로퀀트는 시간값이 자동으로 저장됩니다)

//    첫번째 방법
//    $article = new Article;
//    $article->body = $input['body'];
//    $article->user_id = Auth::id();
//    $article->save();

        // 두번째 방법
        Article::create([
            'body' => $input['body'],
            'user_id' => Auth::id()
        ]);

        // 조회방법
//    $article = Article::find(9);
//    $article->user;

        return redirect()->route('articles.index');
    }

    public function index(Request $request){
        // 모든 글 가져오기
        // $articles = Article::all();

        $q = $request->input('q');

        $page = $request->input('page', 1); // GET page 값 가져오기
        $perPage = $request->input('per_page', 4); // GET per_page 값 가져오기
        $offset = ($page - 1) * $perPage;

        $articles = Article::with('user') // with 방법을 통해 user 값을 한번에 가져온다
        // -> select('body', 'user_id', 'created_at')
        // ->orderBy('created_at', 'desc') // created_at 기준으로 내림차순
        // ->orderBy('body', 'asc') // body 기준으로
        // ->inRandomOrder() // 랜덤으로 출력해야할 때
        // ->oldest() // 가장 오래된 순서로
        // ->take($perPage) // 개수 제한
        // ->skip($offset) // 페이지 변경
        ->when($q, function($query, $q){
            $query->where('body', 'like', "%$q%")
            ->orWhereHas('user', function(Builder $query) use ($q) {
                $query->where('user_id', 'like', "%$q%");
            });
        })
        ->withCount('comments')
        ->withExists(['comments as recent_comments_exists'=>function($query){
            $query->where('created_at', '>', Carbon::now()->subDay());        }]) // 조건에 맞는 댓글을 찾기 subHour subDay 기준
        ->latest() // orderby created_at desc 와 같습니다
        ->paginate($perPage); // 페이지네이션 처리 지원
        // ->get();

        // $articles->load('user'); // with 방법 외에 한번에 출력하는 방법

        $results = DB::table('articles AS a')
            ->join('users AS u', 'a.user_id', '=', 'u.id')
            ->select(['a.*', 'u.name'])
            ->latest() // orderby created_at desc 와 같습니다
            ->paginate(); // 페이지네이션 처리 지원
        ;

        $articles->withQueryString(); // 페이지네이션 처리해도 get 값 그대로 가지고 이동
        $articles->appends(['filter'=>'name']); // GET, POST 등 인수 인자값 추가 가능 (이를 쿼리스트링 추가 가능 이라고 함)
//    $totalCount = Article::count();

        // 명령어 입력시 [블레이드로 만든 페이지네이션 페이지 파일] 생성
        // sail artisan vendor:publish --tag=laravel-pagination

        /* 20. Carbon -------------------------------------------------- */
        //$now = Carbon::now();
        //$past = clone $now;
        //$past->subHours;

        //Carbon::now(); // 현재 시간 출력
        //Carbon::now()->subHours(1)->addMinutes(10); // 현재 시간 + 한시간 후
        /* -------------------------------------------------------------- */

        // dd($now->diffInminutes($past)); // 비교

        // view 두번째 아규먼트에 값을 넘길 수 있습니다.
        return view('articles.index', [
            'articles_name' => $articles,
             'results_name' => $results,
            'q' => $q,
//        'totalCount' => $totalCount,
//        'page' => $page,
//        'perPage' => $perPage
        ]);
//    return view('articles.index')->with('articles_name', $articles); // 위의 코드와 같은 기능 번거롭기에 잘 안씀
    }

    public function show(Article $article) {

        $article->load('comments.user');
        // return 'here';

        // 경로 모델 바인딩을 사용하여, 'articles/{article}' URL로부터 Article 모델의 인스턴스를 직접 받습니다.
        // Property [body] does not exist on this collection instance. 에러가 뜬다면 아래 코드를 주석할 것
        // $article = Article::find($article); // 불필요한 find 호출을 제거합니다.

        return view('articles.show', ['article'=> $article]);

        // dd($article);
    }

    public function edit(EditArticleRequest $request, Article $article){

//        $this->authorize('update', $article);
        return view('articles.edit', ['article'=> $article]);

        // dd($article);
    }

    public function update(UpdateArticleRequest $request, Article $article){

        // The POST method is not supported for route articles/12/update. Supported methods: PUT.
        // 폼에 <input type="hidden" name="_method" value="PUT"> 추가
        // put 은 멱등성을 가지고 있다 : 연산을 여러 번 하더라도 결과가 달라지지 않는 성질
        // patch 는 일부만 바뀐다 (멱등성이 보장안됨)
        // 즉 put은 전체가 바뀜, patch 는 일부만 바뀜

        // 첫번째 인증 방법
//        if(!Auth::user()->can('update', $article)) {
//            abort(403);
//        }

        // 두번째 인증 방법
        $this->authorize('update', $article);

        /* DB 파사드 방식 */
        $input = $request->validated();

        $article->body = $input['body'];
        $article->save();

        return redirect()->route('articles.index');
    }

    public function destroy(DeleteArticleRequest $request, Article $article){
        $article->delete();

        return redirect()->route('articles.index');
    }
}
