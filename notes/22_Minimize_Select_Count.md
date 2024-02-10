
SELECT 할 때 N+1 문제가 발생
> 지금의 방법을 사용하면 여러번 쿼리 SELECT 호출하기 때문에 문제가 됩니다

### 라라벨 텔레스코프 설치

https://laravel.com/docs/10.x/telescope

쿼리 체크하는 도구라고 생각하면됩니다

### 로컬 환경에서만 설치

```
composer require laravel/telescope --dev
 
php artisan telescope:install
 
php artisan migrate
```

http://localhost/telescope/requests


```angular2html
        {{-- foreach 문 사용 --}}
        @foreach($articles_name as $article)
            {{-- 첫번째 루프만 출력 --}}
            @if($loop->first)
                @continue
            @endif
            <div class="background-white border rounded mb-3 p-3">
                    <?php //{!! $article->body !!} // 문장에서 자바스크립트 실행됨 ?>
                {{ $article->body }}
                {{ dd($article->user) }} {{-- attribute 안에 인자값이 들어있음 --}}
                {{ $article->user->name }}
                {{ $article->created_at }}
                {{ $article->created_at->format('Y년 m월 d일 H:i:s') }}
                {{ $article->created_at->diffForHumans() }} {{-- ~분전 --}}
            </div>
        @endforeach

```

여기서 user 를 foreach 를 통해 여러번 호출하게 되기에
한번에 가져오는 방법을 사용해야 합니다

이를 Eagerloading 이라고 합니다

```angular2php
    $articles = Article::with('user')
-> select('body', 'user_id', 'created_at')
->latest() // orderby created_at desc 와 같습니다
->paginate($perPage); // 페이지네이션 처리 지원
```

Article::with('user') 와 같이 출력하거나

```angular2html
    $articles->load('user'); // 한번에 출력하는 방법
```

위와 같이 미리 한번에 로드하여 출력하는 방법을 사용하시면 됩니다.
