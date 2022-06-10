<template>
    <div class="container">
        <site-header></site-header>
        <div class="sidebar">sidebar</div>
        <site-body :show-impressum="showImpressum"></site-body>
        <site-footer  @show="show"></site-footer>
        <cookie-consent/>
        <div class="wait">
            <input id="input" type="text" size="40">
            <button id="send" v-on:click="sendMessage()">Send</button>
            <hr>
            <ul id="log"></ul>
            {{info}}
        </div>
    </div>
</template>

<script>
import CookieConsent from 'vue-cookieconsent-component'
import SiteHeader from "./site-header";
import SiteBody from "./site-body";
import SiteFooter from "./site-footer";
export default {
    name: "articles",
    components: {
        SiteHeader,
        SiteBody,
        SiteFooter,
        CookieConsent
    },
    data() {
        return {
            conn: null,
            showImpressum: false,
            info: "",
            user_id: null
        };
    },
    methods: {
        show(){
            this.showImpressum = !this.showImpressum;
        },
        sendMessage(){
            this.conn.send("Test");
        },
        sshow(direction, msg) {
            let li = document.createElement('li');
            li.innerHTML = direction + ': ' + msg;
            document.getElementById('log').append(li);
        }

    },
    mounted() {
        // this.conn = new WebSocket('ws://localhost:8085/chat');
        // this.user_id = 5; //mocked
        // this.conn.onmessage = (e) => {
        //     if(e.data != null && e.data !== "")
        //     {
        //         // axios.post('/api/islogged', { withCredentials: true }).then(response => {
        //         //     console.log(response);
        //         // })
        //         // .catch(error => {
        //         //     console.log(error);
        //         // })
        //         if(this.user_id === 5)
        //         {
        //             alert(e.data);
        //         }
        //
        //     }
        //     // console.log(e.data);
        //     // this.info = e.data;
        // };
        // this.conn.onopen = (e) => {
        //     this.conn.send('UserA entered the room!');
        // };
        document.getElementById('send').addEventListener('click', () => {
            const msg = document.getElementById('input').value;
            this.conn.send(msg);
            this.sshow('send', msg);
        });
    }
}
</script>

<style scoped>

</style>
