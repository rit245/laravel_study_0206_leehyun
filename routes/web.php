<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;

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

// app/http/controllers/ArticleController.php

/* 생성 페이지 */
//Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
//
///* 생성 명령어 */
//Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
//
///* 목록 페이지 */
//Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
//
///* 글 페이지 */
//Route::get('articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
//
///* 글 수정 페이지 */
//Route::get('articles/{article}/edit',[ArticleController::class, 'edit'])->name('articles.edit');
//
///* 글 수정 처리 */
//Route::patch('articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
//
///* 글 삭제 처리 */
//Route::delete('articles/{article}', [ArticleController::class, 'delete'])->name('articles.destroy');

//Route::controller(ArticleController::class)->group(function(){
//
//    /* 생성 페이지 */
//    Route::get('/articles/create', 'create')->name('articles.create');
//
//    /* 생성 명령어 */
//    Route::post('/articles', 'store')->name('articles.store');
//
//    /* 목록 페이지 */
//    Route::get('articles', 'index')->name('articles.index');
//
//    /* 글 페이지 */
//    Route::get('articles/{article}', 'show')->name('articles.show');
//
//    /* 글 수정 페이지 */
//    Route::get('articles/{article}/edit', 'edit')->name('articles.edit');
//
//    /* 글 수정 처리 */
//    Route::patch('articles/{article}', 'update')->name('articles.update');
//
//    /* 글 삭제 처리 */
//    Route::delete('articles/{article}', 'delete')->name('articles.destroy');
//
//});


Route::resource('articles', ArticleController::class); // 리소스 라우트가 존재하기에 한줄로 처리 가능

