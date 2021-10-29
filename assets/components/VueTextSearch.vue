<template>
    <div class="contenedor-flex">
        <textarea class="text-input" :rows=textRows  @keyup.enter="submit" v-model="input"></textarea>
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

            textAdjust(event) {

            },

            submit() {
                
                console.log(this.input)
            }
        },
        beforeUpdate () {
            if(this.input.length % 19 == 0){
                this.textRows = this.input.length / 19 + 1;
            }
            if(this.input.length == 0){
                this.textRows = 1;
            }
            return;
        }
    }
</script>

<style lang="scss" scoped>

    .text-input {
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

