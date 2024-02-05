<html>
<head>
</head>
<body>
    <div class="container p5">
        <h1 class="text-2xl">글쓰기</h1>
        <form action="/articles" method="post">
            @csrf
            <input type="text" class="block">
            <button class="py-1">
                시작하기
            </button>
        </form>
    </div>
</body>
</html>
