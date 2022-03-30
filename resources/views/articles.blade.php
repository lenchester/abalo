<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>articles</title>
</head>
<body>
    <h1>Articles</h1>
    <form method="get" action="/articles/">
        <label for="search">search</label>
        <input type="text" id="search" name="search">

    </form>
    @foreach($articles as $article)
        <div>
            {{$article->ab_name}}
        </div>
    @endforeach
</body>
</html>
