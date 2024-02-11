@can('update', $article)
    <p class="mr-1">
        <a>{{ $article->created_at->diffForHumans() }} {{-- ~분전 --}}
        </a>
    </p>
    {{-- 에러 난다면 날짜값이 없어서 그런 것 --}}
<div class="flex flex-row mt-2">
    <p class="mt-1"><a class="button rounded bg-blue-500 px-3 py-1 text-xs text-white" href="{{ route('articles.edit', ['article' => $article->id]) }}">수정</a></p>
    @endcan
    @can('delete', $article)
        <form action="{{route('articles.destroy', ['article'=>$article->id])}}" method="POST">
            @csrf
            @method('DELETE')
            <button class="button rounded bg-red-500 px-3 py-1 text-xs text-white">삭제</button>
        </form>
    @endcan
</div>
