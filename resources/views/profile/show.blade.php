<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="text-center">
                <h1 class="text-center text-xl text-bold">{{$user->name}}</h1>
                <div>
                    {{ $user->articles->count() }}
                </div>
            </div>

            <div>
                @forelse($user->articles as $article)
                    <x-list-article-item :article=$article />
                @empty
                    <p>게시물이 없습니다.</p>
                @endforelse

                    @foreach($user->articles as $article)
                    @endforeach


            </div>
        </div>
    </div>
</x-app-layout>
