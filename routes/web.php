<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;

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
Route::post('/articles', function(Request $request) {
    // 비어있지않고, 문자열이고, 255자를 넘으면 안된다
    $input = $request->validate([
        'body' => [
            'required',
            'string',
            /*'boolean', // 10강 7:50 */
            'max:255'
        ],
    ]);

    $host = config('database.connections.mysql.host');
    $dbname = config('database.connections.mysql.database');
    $username = config('database.connections.mysql.username');
    $password = config('database.connections.mysql.password');

    // pdo 객체를 만들고
//    $conn = new PDO("mysql:host=호스트명;dbname=데이터베이스명", 사용자명, 패스워드);
    $conn = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);

    $stmt = $conn->prepare("INSERT INTO articles (body, user_id) VALUES (:body, :userId)");

//    dd($request->all());
//    $request->all();
//    $body = $request->input('body');

//    $request->user()->id
//    Auth::id(); // 로그인한 사용자의 아이디가 담김

//    $stmt->bindValue(':body', '본문내용');
//    $stmt->bindValue(':userId', '사용자의 아이디');

    $stmt->bindValue(':body', $input['body']);
    $stmt->bindValue(':userId', Auth::id());

    $stmt->execute();


    return 'hello22';
});

