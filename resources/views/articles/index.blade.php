{{-- https://carbon.nesbot.com/ 사용법 챙김 --}}
<x-app-layout>
    <div class="container p5">

        {{-- 글 목록 articles_name 에서 가져옴 --}}
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">글목록</h2>
                <div>
                    <form method="GET" action="{{route('articles.index')}}">
                    <input type="text" name="q" class="rounded border-gray-200" placeholder="{{$q ?? "검색"}}">
                    </form>
                </div>
            </div>
        </x-slot>
        <?php //dd($articles_name); ?>

            {{-- foreach 문 사용 --}}
            @foreach($articles_name as $article)
                <x-list-article-item :article=$article />
            @endforeach

        {{-- 페이지네이션 처리 (디자인도 해줍니다) --}}
        <div class="container p-5">
            {{ $articles_name->links() }}
        </div>
    </div>
</x-app-layout>
