export default {
    template: `<footer>
    <p><a v-on:click="showImpressum()">Impressum</a></p>
    </footer>`,
    methods:{
        showImpressum(){
            console.log('Show Impressum');
            this.$emit('show', true);
        }
    }
}






