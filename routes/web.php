<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
    $request->validate([
        'body' => [
            'required',
            'string',
            /*'boolean', // 10강 7:50 */
            'max:255'
        ],
    ]);
    return 'hello';
});
