<html>
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container p5">
        <h1 class="text-2xl">글목록</h1>
        <?php //dd($articles_name); ?>
        <?php foreach($articles_name as $article): ?>
            <div class="background-white border rounded mb-3 p-3">
                <?php echo $article->body; ?>
                <?php echo $article->created_at; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
