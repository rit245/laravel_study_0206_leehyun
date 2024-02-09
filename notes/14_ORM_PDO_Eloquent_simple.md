
생 PHP 방식 저장

```
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
    $stmt->bindValue(':userId', 1);

    $stmt->execute();


    return 'hello'.$_POST['body'];
});
```

```angular2html
    DB::statement("INSERT INTO articles (body, user_id) VALUES (:body, :userId)", ['body' => $input['body'], 'userId' => Auth::id()]);
```

statement : index 를 만들거나 할 때 사용


```angular2html
    DB::insert("INSERT INTO articles (body, user_id) VALUES (:body, :userId)", ['body' => $input['body'], 'userId' => Auth::id()]);
```

CRUD를 사용하신다면 DB:insert, DB:update, DB:delete 등으로 활용 가능

```angular2html

    // 엘로퀀트 ORM 사용방법

    첫번째 방법
    $article = new Article;
    $article->body = $input['body'];
    $article->user_id = Auth::id();
    $article->save();

    // 두번째 방법
    Article::create([
        'body' => $input['body'],
        'user_id' => Auth::id()
    ]);

    // 조회방법
    $article = Article::find(9);
    $article->user;

```
