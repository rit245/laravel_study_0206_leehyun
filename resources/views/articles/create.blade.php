<x-app-layout>
    <div class="container p5">
        <h1 class="text-2xl">글쓰기</h1>
        <form action="{{ route('articles.store') }}" method="post" class="mt-3">
            @csrf
            <input type="text" name="body" class="block w-full mb-2 rounded" value="{{old('body')}}">
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
</x-app-layout>
