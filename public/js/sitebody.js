export default {
    data() {
        return {
            search: "",
            items: [],
            shoppingcart: null,
            shoppingcartid: null,
            offset: 0,
            pagesamount: 0,
            pagebuttons: []
        };
    },
    props:{
        showImpressum: {
            type: Boolean,
            default: false
        }
    },
    mounted() {
        this.getArticleListInit();
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
                    this.getPage(this.offset);
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
                    this.getPage(this.offset);
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
        getPage(offset) {
            if(offset !== null)
            {
                this.offset = offset;
            }
            console.log("getPage called");
            console.log(this.search);
            console.log("offset" + this.offset)
            let params = new URLSearchParams();
            if(this.shoppingcartid)
            {
                params.append("shoppingcartid", self.shoppingcartid);
            }
            params.append("offset", this.offset);
            params.append("search", this.search);
            fetch('./api/newsite/search' +'?'+ params.toString()).then(data => data.json()).then(data => {
                console.log(data);
                console.log("shoppingcartid in getPage = " + self.shoppingcartid);
                this.items = data;
            })
                .catch(err => console.log(err.message));
        },

        getArticleListInit() {
            if (this.search.length > 2 || this.search.length ===0) {
                this.offset = 0;
                let params = new URLSearchParams();
                if (this.shoppingcartid) {
                    params.append("shoppingcartid", self.shoppingcartid);
                }
                params.append("search", this.search);
                fetch('./api/newsite/getsearchnumber?' + '?' + params.toString()).then(data => data.json()).then(data => {
                    let json = data;
                    this.pagesamount = json[0].count;
                    console.log(this.pagesamount);
                    this.generateButtons();
                    this.getPage();
                })
                    .catch(err => console.log(err.message));
            }
        },
        generateButtons() {
            let assocArray = []
            let pagenumber = 1;
            for (var i=0; i < this.pagesamount; i=i+5) {
                var newElement = {};
                newElement['number'] = pagenumber;
                newElement['offset'] = i;
                newElement['checked'] = false;
                assocArray.push(newElement);
                pagenumber++;
            }
            this.pagebuttons = assocArray;
        }
    },
    template:
        `
            <div v-if="this.showImpressum===false">
            Search:<br>
            <input type="text" v-model="search" v-on:keyup="getArticleListInit"><br>
            {{ search }}
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Beschreibung</th>
                    <th>Creator ID</th>
                    <th>Createdate</th>
                </tr>
                <tbody v-if="this.search.length > 2" >
                <tr v-for="item in items" :key="item.ab_name">
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
            <br>
            <div class="btn-group" role="group" aria-label="Basic example" v-for="button in pagebuttons" :key="button.number" v-on:click="getPage(button.offset)">
                <button type="button" class="btn btn-light btn-sm btn-outline-dark" >
                    {{button.number}}
                </button>
            </div>
            <br>
            <br>
            <h4>Warenkorb</h4>
            <div v-if="this.shoppingcart !== null && this.shoppingcart.length > 0" >
            <table>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
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
            </table>
            </div>
            <br><br>

            </div>
        <div v-else>
        <h1></h1>
        <h1>Impressum</h1>

        <h2>Angaben gem&auml;&szlig; &sect; 5 TMG</h2>
        <p>FH Aachen<br />
            Musterstra&szlig;e 111<br />
            Geb&auml;ude 44<br />
            90210 Musterstadt</p>

        <p><strong>Vertreten durch:</strong><br />
            Dr. Harry Mustermann<br />
            Luise Beispiel</p>

        <h2>Kontakt</h2>
        <p>Telefon: +49 (0) 123 44 55 66<br />
            Telefax: +49 (0) 123 44 55 99<br />
            E-Mail: mustermann@musterfirma.de</p>

        <h2>Umsatzsteuer-ID</h2>
        <p>Umsatzsteuer-Identifikationsnummer gem&auml;&szlig; &sect; 27 a Umsatzsteuergesetz:<br />
            DE999999999</p>

        <h2>Verbraucher&shy;streit&shy;beilegung/Universal&shy;schlichtungs&shy;stelle</h2>
        <p>Wir sind nicht bereit oder verpflichtet, an Streitbeilegungsverfahren vor einer Verbraucherschlichtungsstelle teilzunehmen.</p>

        </div>`
}

