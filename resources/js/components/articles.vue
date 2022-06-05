<template>
    <div>
        <site-header></site-header>
        <site-body :show-impressum="showImpressum"></site-body>
        <site-footer  @show="show"></site-footer>
    </div>
</template>

<script>
import SiteHeader from "./site-header";
import SiteBody from "./site-body";
import SiteFooter from "./site-footer";
export default {
    name: "articles",
    components: {
        SiteHeader,
        SiteBody,
        SiteFooter
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
