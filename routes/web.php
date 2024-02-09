<?php

use App\Http\Controllers\ProfileController;
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

Route::get('articles', function(){
    // 모든 글 가져오기
    // $articles = Article::all();

    $page = 2;
    $perPage = 2;
    $offset = ($page - 1) * $perPage;

    $articles = Article::select('body', 'created_at')
        // ->orderBy('created_at', 'desc') // created_at 기준으로 내림차순
        // ->orderBy('body', 'asc') // body 기준으로
        // ->inRandomOrder() // 랜덤으로 출력해야할 때
        // ->latest() // orderby created_at desc 와 같습니다
        // ->take(2) // 개수 제한
        // ->skip($offset) // 페이지 변경
        // ->oldest() // 가장 오래된 순서로
        ->get();


    // view 두번째 아규먼트에 값을 넘길 수 있습니다.
    return view('articles.index', ['articles_name'=>$articles]);
//    return view('articles.index')->with('articles_name', $articles); // 위의 코드와 같은 기능 번거롭기에 잘 안씀
});
