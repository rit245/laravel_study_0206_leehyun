<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Article;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/* articles/create */
Route::get('/articles/create', function () {
    return view('articles/create');
});

/* 저장하기 버튼 클릭 시 */


Route::post('/articles', function(Request $request){
    /* DB 파사드 방식 */
    $input = $request->validate([
                                    'body' => [
                                        'required',
                                        'string',
                                        'max:255'
                                    ],
                                ]);

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

    return 'hello'.$_POST['body'];
});

Route::get('articles', function(Request $request){
    // 모든 글 가져오기
    // $articles = Article::all();

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
//        'totalCount' => $totalCount,
//        'page' => $page,
//        'perPage' => $perPage
    ]);
//    return view('articles.index')->with('articles_name', $articles); // 위의 코드와 같은 기능 번거롭기에 잘 안씀
});

Route::get('articles/{id}', function($id){/**/
   // return 'here';

    $article = Article::find($id);

    return view('articles.show', ['article'=> $article]);

    dd($article);
});
