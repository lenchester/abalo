<template>
    <div>
        <footer>
            <p><a v-on:click="showImpressum()">Impressum</a></p>
        </footer>
    </div>
</template>

<script>
export default {
    name: "site-footer",
    methods:{
        showImpressum(){
            console.log('Show Impressum');
            this.$emit('show', true);
        }
    }
}
</script>

<style scoped>

</style>
