
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>articles</title>
    <script src="js/vue.js"></script>
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




<table>
    <thead>
    <tr>
        <th>Artikel</th>
        <th>Preis</th>
        <th>Zum Warenkorb</th>
    </tr>
    </thead>
    <tbody id="articles">
    </tbody>
</table>

<div id="app">
    Search:<br>
    <input type="text" v-model="search"><br>
    @{{ search }}
    <table>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Beschreibung</th>
            <th>Creator ID</th>
            <th>Createdate</th>
        </tr>
        <tbody v-if="this.search.length > 2">
        <tr v-for="item in itemfilter.slice(0,5)" :key ="item.ab_name" >
            <td class="shop-item-title">@{{item.ab_name}}</td>
            <td class="shop-item-price">@{{item.ab_price}}</td>
            <td>@{{item.ab_description}}</td>
            <td>@{{item.ab_creator_id}}</td>
            <td>@{{item.ab_createdate}}</td>
            <td>
                <button type="button" v-on:click="addToCart(item.id)">
                    add to cart
                </button>
            </td>
        </tr>
        </tbody>
        <tbody v-else>
        <tr v-for="item in itemfilter" :key ="item.ab_name" >
            <td>@{{item.ab_name}}</td>
            <td>@{{item.ab_price}}</td>
            <td>@{{item.ab_description}}</td>
            <td>@{{item.ab_creator_id}}</td>
            <td>@{{item.ab_createdate}}</td>
            <td><button type="button" v-on:click="addToCart(item.id)">
                    add to cart
                </button>
            </td>
        </tr>
        </tbody>
    </table>
    <h2>Warenkorb</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Beschreibung</th>
            <th>Creator ID</th>
            <th>Createdate</th>
        </tr>
        <tbody>
        <tr v-for="item in shoppingcart" :key ="item.ab_name" >
            <td class="shop-item-title">@{{item.ab_name}}</td>
            <td class="shop-item-price">@{{item.ab_price}}</td>
            <td>@{{item.ab_description}}</td>
            <td>@{{item.ab_creator_id}}</td>
            <td>@{{item.ab_createdate}}</td>
            <td><button type="button" v-on:click="removeFromCart(item.id)">
                    remove from cart
                </button>
            </td>
        </tr>
        </tbody>
    </table>
</div>


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
    var vm = Vue.createApp({
        data(){
            return{
                search: "",
                items: [],
                shoppingcart: [],
                shoppingcartid: null
            };
        },
        mounted(){
            fetch('/api/articlesAPI/availableitems').then(data=> data.json()).then(data =>{
                console.log(data);
                this.items  = data;
            })
                .catch(err=>console.log(err.message));

        },
        computed:{
            itemfilter:function () {
                console.log(this.search.length > 2)
                return this.items.filter((article) => {
                    if (this.search.length > 2) {
                        return article.ab_name.toLowerCase().match(this.search.toLowerCase());
                    } else {
                        return true;
                    }
                });
            }
        },
        methods: {
            addToCart: function(itemId) {
                console.log("item id" + itemId);
                let xhr = new XMLHttpRequest();
                let params = new FormData();

                xhr.open("POST", "/api/articlesAPI/addtocart");
                params.append("articleid", itemId);
                params.append("creatorid", "5");
                if(self.shoppingcartid)
                {
                    params.append("shoppingcartid", self.shoppingcartid);
                }
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == XMLHttpRequest.DONE)
                    {
                        if(!self.shoppingcartid)
                        {
                            let response_shoppingcartid = xhr.responseText;
                            self.shoppingcartid = response_shoppingcartid;
                        }
                        vm.getCart();
                        vm.getArticleList();
                    }
                };
                xhr.send(params);
                // this.$data.shoppingcart.push(this.$data.items.find(x => x.id === itemId));
                // this.$data.items = this.$data.items.filter(item => item !== this.$data.items.find(x => x.id === itemId));
            },
            removeFromCart: function(itemId) {
                let xhr = new XMLHttpRequest();
                xhr.open("DELETE", "/api/articlesAPI/removefromcart/" + self.shoppingcartid + "/" + itemId);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == XMLHttpRequest.DONE)
                    {
                        vm.getCart();
                        vm.getArticleList();
                        if(xhr.responseText == '{}')
                        {
                            self.shoppingcartid = null;
                            console.log("Shopping cart is empty, id = 0");
                        }
                    }
                };
                xhr.send();

            },
            getCart(){
                console.log("getCart called");
                let params = new URLSearchParams();
                params.append("shoppingcartid", self.shoppingcartid);
                fetch('/api/articlesAPI/shoppingcartitems?' + params.toString()).then(data => data.json()).then(data => {
                    this.shoppingcart = data;
                })
            },
            getArticleList(){
                console.log("getArticleList called");
                let params = new URLSearchParams();
                params.append("shoppingcartid", self.shoppingcartid);
                fetch('/api/articlesAPI/availableitems?'+ params.toString()).then(data=> data.json()).then(data =>{
                    console.log(data);
                    this.items  = data;
                })
                    .catch(err=>console.log(err.message));
            }
        }
    }).mount('#app');

</script>


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
</script>


</body>
</html>
