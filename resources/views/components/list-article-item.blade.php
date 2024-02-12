<div class="background-white border rounded mb-3 p-3">
    <p><a href="{{ route('articles.show', ['article' => $article->id, 'sort' => 'asc'])  }}">{{ $article->body }}</a></p>
    <p>
        <a href="{{route('profile', ['user' => $article->user->username])}}">
            {{ $article->user->name }}
        </a>
    </p>
    <p>{{ $article->created_at }}</p>
    <span>댓글 {{$article->comments_count}}
        @if($article->comments_exists) (new) @endif
                </span>
    <x-article-button-group :article=$article />
</div>
