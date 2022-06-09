<template>
    <div class="container">
        <site-header></site-header>
        <div class="sidebar">sidebar</div>
        <site-body :show-impressum="showImpressum"></site-body>
        <site-footer  @show="show"></site-footer>
        <cookie-consent/>
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
            showImpressum: false
        };
    },
    methods: {
        show(){
            this.showImpressum = !this.showImpressum;
        }
    }
}
</script>

<style scoped>

</style>
