
sail artisan route:list | grep articles


POST      articles ................ articles.store › ArticleController@store
GET|HEAD  articles ................ articles.index › ArticleController@index
GET|HEAD  articles/create ....... articles.create › ArticleController@create
GET|HEAD  articles/{article} ........ articles.show › ArticleController@show
PATCH     articles/{article} .... articles.update › ArticleController@update
DELETE    articles/{article} .... articles.delete › ArticleController@delete
GET|HEAD  articles/{article}/edit ... articles.edit › ArticleController@edit


delete 를 destroy 로 변경했어야 했습니다

web.php 에서
Route::resource('articles', ArticleController::class);

하나로 라우트를 줄일 수 있었습니다.
