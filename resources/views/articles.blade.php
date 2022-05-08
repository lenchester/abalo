<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>articles</title>
</head>
<body>

    <h1>Warenkorb</h1>
    <table>
        <thead>
        <tr>
            <th>Artikel</th>
            <th>Preis</th>
            <th>Entfernen</th>
        </tr>
        </thead>
        <tbody id="cart">

        </tbody>
    </table>

    <form method="get" action="/articles/">
        <label for="search">search</label>
        <input type="text" id="search" name="search">
    </form>

    <table>
        <thead>
        <tr>
            <th>Artikel</th>
            <th>Preis</th>
            <th>Zum Warenkorb</th>
        </tr>
        </thead>
    <tbody id="articles">
    @foreach($articles as $article)
        <tr>
            <td>{{$article->ab_name}}</td>
            <td>{{$article->ab_price}}</td>
            <td><a href="javascript:;" class="add-button">[ + ]</a></td>
        </tr>
    @endforeach
    </tbody>
    </table>


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
    <script src = "js/navbar.js"></script>
    <script>
        function addToCart(e)
        {
            let article = e.target;
            let articleRow = article.parentElement.parentElement;
            let cart = document.getElementById("cart");
            cart.appendChild(articleRow);
            article.setAttribute("class", "remove-button");
            article.innerHTML = "[ - ]";
            article.removeEventListener('click', addToCart);
            article.addEventListener('click', removeFromCart);

        }

        function removeFromCart(e)
        {
            let article = e.target;
            let articleRow = article.parentElement.parentElement;
            let articles = document.getElementById("articles");
            articles.appendChild(articleRow);
            article.setAttribute("class", "add-button");
            article.innerHTML = "[ + ]";
            article.removeEventListener('click', removeFromCart);
            article.addEventListener('click', addToCart);

        }
        let addButtons = document.getElementsByClassName("add-button");

        for (let i = 0; i < addButtons.length; i++)
        {
            addButtons[i].addEventListener('click', addToCart);
        }

    </script>



</body>
</html>
