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

<div id="app">
    <navbar-new></navbar-new>
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
{{--<script src = "js/navbar.js"></script>--}}
<script type="module">
    import NavbarNew from './js/navbarNew.js';
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
            fetch('/api/newsite/availableitems').then(data=> data.json()).then(data =>{
                console.log(data);
                this.items  = data;
            })
                .catch(err=>console.log(err.message));

        },
        components:
            {
                NavbarNew
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

                xhr.open("POST", "/api/newsite/addtocart");
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
            },
            removeFromCart: function(itemId) {
                let xhr = new XMLHttpRequest();
                xhr.open("DELETE", "/api/newsite/removefromcart/" + self.shoppingcartid + "/" + itemId);
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
                fetch('/api/newsite/shoppingcartitems?' + params.toString()).then(data => data.json()).then(data => {
                    this.shoppingcart = data;
                })
            },
            getArticleList(){
                console.log("getArticleList called");
                let params = new URLSearchParams();
                params.append("shoppingcartid", self.shoppingcartid);
                fetch('/api/newsite/availableitems?'+ params.toString()).then(data=> data.json()).then(data =>{
                    console.log(data);
                    this.items  = data;
                })
                    .catch(err=>console.log(err.message));
            }
        }
    }).mount('#app');



</script>
</body>
</html>
<script>
    import NavbarNew from "../../public/js/navbarNew";
    export default {
        components: {NavbarNew}
    }
</script>
