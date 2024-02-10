route

routes/web/auth.php

```angular2html
Route::get('/articles/create', function () {
    return view('articles/create');
})->name('articles.create');
```

->name('articles.create') 을 붙이면 사용할 수 있게됩니다

```angular2html
<div>
    <a href="{{ route('articles.create') }}">글쓰기</a>
</div>
```
사용은 위와 같이 입력하면 사용할 수 있어요
