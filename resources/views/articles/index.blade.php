{{-- https://carbon.nesbot.com/ 사용법 챙김 --}}

<html>
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container p5">


        {{-- 글 목록 results_name 에서 가져옴 --}}

        <h1 class="text-2xl">글목록 - 조인하여 작성자이름 추가</h1>
        <?php //dd($articles_name); ?>

{{--        --}}{{-- foreach 문 사용 --}}{{--
        @foreach($results_name as $result)
            --}}{{-- 첫번째 루프만 출력 --}}{{--
            @if($loop->first)
                @continue
            @endif
            <div class="background-white border rounded mb-3 p-3">
                <?php //{!! $article->body !!} // 문장에서 자바스크립트 실행됨 ?>
                 <p>{{ $result->body }}</p>
                 <p>{{ $result->created_at }}</p>
                 <p>{{ $result->name }}</p>
            </div>
        @endforeach--}}


        {{-- 글 목록 articles_name 에서 가져옴 --}}


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
                <p>{{ $article->body }}</p>
{{--                <p>{{ dd($article->user) }} --}}{{-- attribute 안에 인자값이 들어있음 --}}
                <p>{{ $article->user->name }}</p>
                <p>{{ $article->created_at }}</p>
                {{-- 에러 난다면 날짜값이 없어서 그런 것 --}}
                <p>{{ $article->created_at->format('Y년 m월 d일 H:i:s') }}</p>
{{--                    <a href="/articles/{{$article->id}}">{{ $article->created_at->diffForHumans() }} --}}{{-- ~분전 --}}{{--
                    </a>--}}
                <p>
                    <a href="{{ route('articles.show', ['article' => $article->id, 'sort' => 'asc'])  }}">{{ $article->created_at->diffForHumans() }} {{-- ~분전 --}}
                    </a>
                </p>
                {{-- 에러 난다면 날짜값이 없어서 그런 것 --}}
                <div class="flex flex-row mt-2">
                <p class="mt-1"><a class="button rounded bg-blue-500 px-3 py-1 text-xs text-white" href="{{ route('articles.edit', ['article' => $article->id]) }}">수정</a></p>

                <form action="{{route('articles.delete', ['article'=>$article->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="button rounded bg-red-500 px-3 py-1 text-xs text-white">삭제</button>
                </form>
                </div>
            </div>
        @endforeach



        {{--  --}}




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
