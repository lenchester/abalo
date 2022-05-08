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
    {{--@foreach($articles as $article)
        <tr>
            <td>{{$article->ab_name}}</td>
            <td>{{$article->ab_price}}</td>
            <td><a href="javascript:;" class="add-button">[ + ]</a></td>
        </tr>
    @endforeach--}}
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
    function getAvailableItems(shoppingcartid)
    {

        console.log("shoppingcartid", shoppingcartid);
        document.getElementById('articles').innerHTML = "";
        let xhr = new XMLHttpRequest();
        let params = new URLSearchParams();
        if(shoppingcartid)
        {
            params.append("shoppingcartid", shoppingcartid);
        }
        xhr.open("GET", "/api/articlesAPI/availableitems?" + params.toString());
        xhr.onreadystatechange = function (){
            if(xhr.readyState === 4)
            {
                let data = JSON.parse(xhr.responseText);
                for (let i = 0; i < data.length; i++)
                {
                    let tableRow = document.createElement('tr'); //Article name and price columns
                    let nameCol = data[i].ab_name;
                    let priceCol = data[i].ab_price;
                    let tdNameCol = document.createElement('td');
                    let tdPriceCol = document.createElement('td');
                    tdNameCol.innerHTML = nameCol;
                    tdPriceCol.innerHTML = priceCol;
                    tableRow.appendChild(tdNameCol);
                    tableRow.appendChild(tdPriceCol);

                    let tdCartButtonWrapper = document.createElement('td'); //ADD/REMOVE cart button column
                    let cartButton = document.createElement('a');
                    cartButton.setAttribute('href', 'javascript:;');
                    cartButton.setAttribute('class', 'add-button');
                    cartButton.innerHTML = '[ + ]';
                    cartButton.dataset.articleid = data[i].id;
                    if(shoppingcartid)
                    {
                        cartButton.dataset.shoppingcartid = shoppingcartid;
                    }

                    tdCartButtonWrapper.appendChild(cartButton);
                    tableRow.appendChild(tdCartButtonWrapper);

                    document.getElementById('articles').appendChild(tableRow);
                    cartButton.addEventListener('click', addToCart);
                }
            }
        }

        xhr.send();
    }
    function getShoppingCart(shoppingcartid)
    {

        document.getElementById('cart').innerHTML = "";
        let xhr = new XMLHttpRequest();
        let params = new URLSearchParams();
        if(shoppingcartid)
        {
            params.append("shoppingcartid", shoppingcartid);
        }
        xhr.open("GET", "/api/articlesAPI/shoppingcartitems?" + params.toString());
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onreadystatechange = function (){
            if(xhr.readyState === 4)
            {
                let data = JSON.parse(xhr.responseText);
                for (let i = 0; i < data.length; i++)
                {
                    let tableRow = document.createElement('tr'); //Article name and price columns
                    let nameCol = data[i].ab_name;
                    let priceCol = data[i].ab_price;
                    let tdNameCol = document.createElement('td');
                    let tdPriceCol = document.createElement('td');
                    tdNameCol.innerHTML = nameCol;
                    tdPriceCol.innerHTML = priceCol;
                    tableRow.appendChild(tdNameCol);
                    tableRow.appendChild(tdPriceCol);

                    let tdCartButtonWrapper = document.createElement('td'); //ADD/REMOVE cart button column
                    let cartButton = document.createElement('a');
                    cartButton.setAttribute('href', 'javascript:;');
                    cartButton.setAttribute('class', 'remove-button');
                    cartButton.innerHTML = '[ - ]';
                    cartButton.dataset.articleid = data[i].id;
                    cartButton.dataset.shoppingcartid = shoppingcartid;
                    tdCartButtonWrapper.appendChild(cartButton);
                    tableRow.appendChild(tdCartButtonWrapper);

                    document.getElementById('cart').appendChild(tableRow);
                    cartButton.addEventListener('click', removeFromCart);
                }
                if(data.length)
                {
                    let tableRow = document.createElement('tr');
                    let controlContainer = document.createElement('td');
                    controlContainer.setAttribute('colspan', '3');
                    tableRow.appendChild(controlContainer);
                    let cartButton = document.createElement('a');
                    cartButton.setAttribute('href', 'javascript:;');
                    cartButton.setAttribute('class', 'empty-cart-button');
                    cartButton.innerHTML = '[ X ]';
                    cartButton.title = 'Remove All';
                    controlContainer.setAttribute('class', 'cart-control-container');
                    cartButton.dataset.shoppingcartid = shoppingcartid;
                    cartButton.addEventListener('click', emptyCart);
                    controlContainer.appendChild(cartButton);
                    document.getElementById('cart').appendChild(tableRow);


                }
            }
        }
        xhr.send();
    }
    function addToCart(e)
    {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/api/articlesAPI/addtocart");
        xhr.onreadystatechange = function (){
            if(xhr.readyState === 4)
            {
                let data = JSON.parse(xhr.responseText);
                getAvailableItems(data);
                getShoppingCart(data);
            }
        }
        let articleid = e.target.dataset.articleid;
        let params = new FormData();
        params.append("articleid", articleid);
        params.append("creatorid", "5");
        if(e.target.dataset["shoppingcartid"])
        {
            params.append("shoppingcartid", e.target.dataset.shoppingcartid);
        }
        xhr.send(params);

    }
    function removeFromCart(e)
    {
        let xhr = new XMLHttpRequest();
        let shoppingcartid = e.target.dataset["shoppingcartid"];
        let articleid = e.target.dataset["articleid"];
        xhr.open("DELETE", "/api/articlesAPI/removefromcart/" + shoppingcartid + "/" + articleid);
        xhr.onreadystatechange = function (){
            if(xhr.readyState === 4)
            {
                console.log("RESPONSE ", xhr.responseText);
                let data = JSON.parse(xhr.responseText);
                getAvailableItems(data[0]);
                getShoppingCart(data[0]);
            }
        }

        xhr.send();
    }
    function emptyCart(e)
    {
        let xhr = new XMLHttpRequest();
        let shoppingcartid = e.target.dataset["shoppingcartid"];
        xhr.open("DELETE", "/api/articlesAPI/emptycart/" + shoppingcartid);
        xhr.onreadystatechange = function (){
            if(xhr.readyState === 4)
            {
                console.log("RESPONSE ", xhr.responseText);
                let data = JSON.parse(xhr.responseText);
                getAvailableItems(data[0]);
                getShoppingCart(data[0]);
            }
        }
        xhr.send();
    }

    document.addEventListener('DOMContentLoaded', function() {
        getShoppingCart(null);
        getAvailableItems(null);

    });


 /*   function addToCart(e)
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

    let xhr = new XMLHttpRequest();
    xhr.open("GET", "/api/articlesAPI" + window.location.search);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function (){
        if(xhr.readyState === 4)
        {
            if(xhr.status === 200){
                let data = JSON.parse(xhr.responseText);
                console.log(data);
                for (let i = 0; i < data.length; i++)
                {
                    let tableRow = document.createElement('tr'); //Article name and price columns
                    tableRow.setAttribute('id', data[i].id);
                    let nameCol = data[i].ab_name;
                    let priceCol = data[i].ab_price;
                    let tdNameCol = document.createElement('td');
                    let tdPriceCol = document.createElement('td');
                    tdNameCol.innerHTML = nameCol;
                    tdPriceCol.innerHTML = priceCol;
                    tableRow.appendChild(tdNameCol);
                    tableRow.appendChild(tdPriceCol);

                    let tdCartButtonWrapper = document.createElement('td'); //ADD/REMOVE cart button column
                    let cartButton = document.createElement('a');
                    cartButton.setAttribute('href', 'javascript:;');
                    cartButton.setAttribute('class', 'add-button');
                    cartButton.innerHTML = '[ + ]';
                    tdCartButtonWrapper.appendChild(cartButton);
                    tableRow.appendChild(tdCartButtonWrapper);

                    document.getElementById('articles').appendChild(tableRow);
                }

                let addButtons = document.getElementsByClassName("add-button");
                console.log(addButtons);

                for (let i = 0; i < addButtons.length; i++)
                {
                    addButtons[i].addEventListener('click', addToCart);
                }
            }
        }
    }
    xhr.send();
*/
</script>


</body>
</html>
