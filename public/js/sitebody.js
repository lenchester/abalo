export default {
    data() {
        return {
            search: "",
            items: [],
            shoppingcart: [],
            shoppingcartid: null
        };
    },
    mounted() {
        fetch('/api/newsite/availableitems').then(data => data.json()).then(data => {
            console.log(data);
            this.items = data;
        })
            .catch(err => console.log(err.message));

    },
    computed: {
        itemfilter: function () {
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
        addToCart: function (itemId) {
            console.log("item id" + itemId);
            let xhr = new XMLHttpRequest();
            let params = new FormData();

            xhr.open("POST", "/api/newsite/addtocart");
            params.append("articleid", itemId);
            params.append("creatorid", "5");
            if (self.shoppingcartid) {
                params.append("shoppingcartid", self.shoppingcartid);
            }
            xhr.onreadystatechange = () => {
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    if (!self.shoppingcartid) {
                        let response_shoppingcartid = xhr.responseText;
                        self.shoppingcartid = response_shoppingcartid;
                    }
                    console.log(this);
                    this.getCart();
                    this.getArticleList();
                }
            };
            xhr.send(params);
        },
        removeFromCart: function (itemId) {
            let xhr = new XMLHttpRequest();
            xhr.open("DELETE", "/api/newsite/removefromcart/" + self.shoppingcartid + "/" + itemId);
            xhr.onreadystatechange = () => {
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    this.getCart();
                    this.getArticleList();
                    if (xhr.responseText == '{}') {
                        self.shoppingcartid = null;
                        console.log("Shopping cart is empty, id = 0");
                    }
                }
            };
            xhr.send();

        },
        getCart() {
            console.log("getCart called");
            let params = new URLSearchParams();
            params.append("shoppingcartid", self.shoppingcartid);
            fetch('/api/newsite/shoppingcartitems?' + params.toString()).then(data => data.json()).then(data => {
                this.shoppingcart = data;
            })
        },
        getArticleList() {
            console.log("getArticleList called");
            let params = new URLSearchParams();
            params.append("shoppingcartid", self.shoppingcartid);
            fetch('/api/newsite/availableitems?' + params.toString()).then(data => data.json()).then(data => {
                console.log(data);
                this.items = data;
            })
                .catch(err => console.log(err.message));
        }
    },
    template:
        `Search:<br>
    <input type="text" v-model="search"><br>
    {{ search }}
    <table>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Beschreibung</th>
            <th>Creator ID</th>
            <th>Createdate</th>
        </tr>
        <tbody v-if="this.search.length > 2">
        <tr v-for="item in itemfilter.slice(0,5)" :key="item.ab_name">
            <td class="shop-item-title">{{ item.ab_name }}</td>
            <td class="shop-item-price">{{ item.ab_price }}</td>
            <td>{{ item.ab_description }}</td>
            <td>{{ item.ab_creator_id }}</td>
            <td>{{ item.ab_createdate }}</td>
            <td>
                <button type="button" v-on:click="addToCart(item.id)">
                    add to cart
                </button>
            </td>
        </tr>
        </tbody>
        <tbody v-else>
        <tr v-for="item in itemfilter" :key="item.ab_name">
            <td>{{ item.ab_name }}</td>
            <td>{{ item.ab_price }}</td>
            <td>{{ item.ab_description }}</td>
            <td>{{ item.ab_creator_id }}</td>
            <td>{{ item.ab_createdate }}</td>
            <td>
                <button type="button" v-on:click="addToCart(item.id)">
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
        <tr v-for="item in shoppingcart" :key="item.ab_name">
            <td class="shop-item-title">{{ item.ab_name }}</td>
            <td class="shop-item-price">{{ item.ab_price }}</td>
            <td>{{ item.ab_description }}</td>
            <td>{{ item.ab_creator_id }}</td>
            <td>{{ item.ab_createdate }}</td>
            <td>
                <button type="button" v-on:click="removeFromCart(item.id)">
                    remove from cart
                </button>
            </td>
        </tr>
        </tbody>
    </table>`
}
