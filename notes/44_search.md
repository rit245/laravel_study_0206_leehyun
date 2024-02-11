                <div>
                    <form method="GET" action="{{route('articles.index')}}">
                    <input type="text" name="q" class="rounded border-gray-200" placeholder="{{$q ?? "검색"}}">
                    </form>
                </div>


당장은 쿼리를 통해 검색합니다.
