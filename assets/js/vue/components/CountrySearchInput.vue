<template>
    <div class="contenedor-flex">
        <textarea id="text-input" maxlength="74" :rows=textRows  @keydown.enter.prevent="submit" v-model="input"></textarea>
        <div class="texto-error" v-if="ciudadNoExiste"> {{errorMessage}} </div>    
    </div>
</template>

<script>
    import {search} from "../../facade/SearchFacade";
    export default {
        name: "CountrySearchInput",
        data () {
            return {
                input: "",
                ciudadNoExiste: true,
                errorMessage:"Esa ciudad no existe",
                textRows: 1,
            }
        },
        methods: {

            submit() {
                // Vue llama al endpoint con un post del nombre introducido
                search(this.input)
                .then(response => {window.location.replace('/');})
                .catch((error) => { this.error=true; this.errorMessage=error});
                // El endpoint responde que si existe o no

                // Vue muestra mensaje de error

                // Vue llama a controlador de cityViewer
            },

            updateInputHeight() {
                if (this.textRows <= 6) this.textRows = this.input.length / 16 + 1;
            },
            preventUselessWhitespaces() {
                // Al final 1 espacio
                if (this.input.slice(-2) === "  "){
                    this.input= this.input.slice(0,-1);
                }
                // Al principio ningun espacio
                if (this.input.charAt(0) === " "){
                    this.input= this.input.slice(1);
                }
            }

        },
        updated () {
            this.updateInputHeight();
            this.preventUselessWhitespaces(); 
        }
    }
</script>

<style lang="scss" scoped>

    #text-input {
        text-align: center;
        font-size: 1.5rem;
        resize: none !important;
        overflow:hidden;

        border-radius: 25px;
        border: 2px solid rgb(37, 197, 197);
        background: linear-gradient(135deg, rgba(0,99,182,0.75) 13%,
                                            rgba(0,99,182,0.5) 50%, 
                                            rgba(0,99,182,0.75) 100%);
        padding: 0.3em;
        resize: both;
        color: $primary-color;
        width: 12em;

        &:hover {
            border: 2px solid rgb(0, 255, 255);
        }

        &:focus {
            outline: none;
        }
    }

    .contenedor-flex{
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .texto-error{
        padding: 1em;
        color: red;
    }

</style>

