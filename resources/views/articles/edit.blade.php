<html>
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="container p5">
    <h1 class="text-2xl">글 수정하기</h1>
    <form action="{{ route('articles.update', ['article'=> $article->id]) }}" method="post" class="mt-3">
        @csrf
        @method('PATCH')
        {{--<input type="hidden" name="_method" value="PUT"> // put 메소드를 사용할 때 추가해야함 --}}
        <input type="text" name="body" class="block w-full mb-2 rounded" value="{{ old('body') ?? $article->body }}">
        @error('body')
        <p class="text-xs text-red-500 mb-3"> {{ $message }} </p>
        @enderror
        <button class="py-1 px-3 bg-black text-white rounded text-xs">
            저장하기
        </button>
        {{--            {{ dd($errors) }}--}}
        {{--            {{ dd($errors->all) }}--}}
        {{--            {{ dd($errors->any) }}--}}
        {{--            {{ dd($errors->first('body')) }}--}}
        {{--            {{ dd(request()->session()) }} // 12강 --}}
    </form>
</div>
</body>
</html>
