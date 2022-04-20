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
    <div id="cookieNotice" class="light display-right" style="display: none;">
        <div id="closeIcon" style="display: none;">
        </div>
        <div class="title-wrap">
            <h4>Cookie Consent</h4>
        </div>
        <div class="content-wrap">
            <div class="msg-wrap">
                <p>TSeit Mai 2018 gilt die EU DSGVO (EU-Datenschutz- grundverordnung). Die DSGVO verlangt, dass bei Verwendung von Cookies der/die Nutzer:in über die Verwendung selbst sowie über die geltende Rechtsgrundlage unterrichtet wird. Ein Beispiel finden Sie unter https://www.fh- aachen.de.  <a style="color:#115cfa;" href="/privacy-policy">Privacy Policy</a></p>
                <div class="btn-wrap">
                    <button class="btn-primary" onclick="acceptCookieConsent();">Accept</button>
                </div>
            </div>
        </div>
    </div>
    <script src="js/cookiecheck.js"></script>
</body>
</html>
