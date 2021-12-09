<template>
    <div class="contenedor-flex">
        <textarea id="text-input" maxlength="74" :rows=textRows  @keydown.enter.prevent="submit" v-model="input"></textarea>
        <div class="texto-error" v-if="ciudadNoExiste"> {{errorMessage}} </div>    
    </div>
</template>

<script>
    export default {
        name: "VueTextSearch",
        data () {
            return {
                input: "",
                ciudadNoExiste: false,
                errorMessage:"Esa ciudad no existe",
                textRows: 1,
            }
        },
        methods: {

            submit() {
                console.log(this.input)
            },

            getInputTextWidth() {

                let inputElement = document.getElementById("text-input");
                // Canvas para determinar el ancho que ocupa cada letra en el input
                let canvas = document.createElement("canvas");
                let context = canvas.getContext("2d");
                context.font = "1.5rem Helvetica" // inputElement.style.fontSize + inputElement.font;
                let contextWidth = context.measureText(this.input).width;
                console.log(contextWidth)
                return Math.ceil(contextWidth);
                
            },

            updateInputHeight() {
                if (this.textRows <= 6) this.textRows = this.input.length / 16 + 1;
                /* Lee ancho de las letras en pixeles
                    Inutil porque:
                        1. Diferente en cada browser
                        2. Las mayusculas se toman en minusculas
                let inputElement = document.getElementById("text-input");
                this.textRows = Math.trunc(this.getInputTextWidth() / (inputElement.clientWidth)) + 1;
                if(this.input.length == 0){
                    this.textRows = 1;
                } */
            },
            preventMultipleWhitespaces() {
                if (this.input.slice(-2) == "  "){
                    this.input= this.input.slice(0,-1)
                }
            }

        },
        updated () {
            this.updateInputHeight();
            this.preventMultipleWhitespaces(); // Solo un espacio
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
        color: darkred;
    }

</style>

