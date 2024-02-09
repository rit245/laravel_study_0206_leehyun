<html>
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container p5">
        <h1 class="text-2xl">글목록</h1>
        <?php //dd($articles_name); ?>

        {{-- foreach 문 사용 --}}
        @foreach($articles_name as $article)
            {{-- 첫번째 루프만 출력 --}}
            @if($loop->first)
                @continue
            @endif
            <div class="background-white border rounded mb-3 p-3">
                <?php //{!! $article->body !!} // 문장에서 자바스크립트 실행됨 ?>
                 {{ $article->body }}
                 {{ $article->created_at }}
            </div>
        @endforeach

{{--        <ul>--}}
{{--            @for($i=0; $i < $totalCount/$perPage; $i++)--}}
{{--            <li>--}}
{{--                <a href="/articles?page={{$i+1}}&per_page={{$perPage}}">{{$i+1}}</a>--}}
{{--            </li>--}}
{{--            @endfor--}}
{{--        </ul>--}}

        {{-- 페이지네이션 처리 (디자인도 해줍니다) --}}
        <div class="container p-5">
            {{ $articles_name->links() }}
        </div>

        {{-- for 문 사용 즉 전체가 나옴 --}}
        @for($i=0; $i < $articles_name->count(); $i++)

            @if($i === 1)
                @continue;
            @endif

            @isset($i) {{-- php의 isset 과 동일 --}}
            @endisset
            @empty($i) {{-- php의 empty 와 동일 --}}
            @endempty
            @auth {{-- 로그인한사용자만 보이고싶을 때 --}}
            로그인한 사용자만 보임
            @endauth
            @guest {{-- 비회원만 보이고싶을때 --}}
            비회원만 보임
            @endguest
            <p>{{  $i  }}</p>
            <p>{{  $articles_name[$i]->body  }}</p>
            <p>{{  $articles_name[$i]->created_at  }}</p>
        @endfor
    </div>
</body>
</html>
