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
                    게시물 {{ $user->articles->count() }}
                    구독자 {{ $user->followers()->count() }}
                </div>

{{--                @if(Auth::id() != $user->id) --}}{{-- 내 아이디 구독버튼 안보이게 --}}
                @if(true) {{-- 내 아이디 구독버튼 안보이게 --}}
                <div>
                    @if(Auth::user()->isFollowing($user))
                        <form method="POST" action="{{ route('unfollow', ['user'=>$user->username])  }}">
                            @csrf
                            @method('delete')
                            <x-danger-button>구독해지</x-danger-button>
                        </form>

                    @else
                        <form method="POST" action="{{ route('follow', ['user'=>$user->username])  }}">
                            @csrf
                            <x-primary-button>구독하기</x-primary-button>
                        </form>

                    @endif
                </div>
                @endif
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
