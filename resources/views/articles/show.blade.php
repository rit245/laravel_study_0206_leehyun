<html>
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container p5">
        <h1 class="text-2xl mb-5">
            {{ $article->body }}
        </h1>
    </div>
</body>
