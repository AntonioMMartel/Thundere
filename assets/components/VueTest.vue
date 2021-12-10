<template>
    <article>
        <div class="container-main">
            <vue-fading-lights-animation/>
            <div class="container-ui">
                <div class="title">{{ testResponse.title}}</div> 
                <div class="texto"> {{ testResponse.data }} </div>
            </div>
        </div>
    </article>
</template>

<script>
import VueFadingLightsAnimation from './VueFadingLightsAnimation.vue'
    export default {
        name: 'VueTest',
        components: {VueFadingLightsAnimation},
        props : ["entrada"],
        data(){
            return {
                testResponse: {
                    title: "Error",
                    data: "No ha llegado nada"
                }
            }
        }, 
        beforeMount (){
           this.testResponse = JSON.parse(this.entrada);
        }
    }
</script>

<style lang="scss" scoped>
    .title {
        font-size: 7rem;     
        text-align: center;
    }

    .container-main {
        display:flex;
        min-height: 80vh;
        height:auto;
        flex-wrap: wrap;
        color: $primary-color;
    }

    .container-ui {
        width: 100%;
        height: 80vh;
        
        display: flex;
        flex-direction: column;
        align-items: center;

        div:first-child{
            padding-bottom: 0.3em ;
            padding-top: 1.2em;
        }
        
    }

    .texto {
        font-size: 2rem;
        width: 80%
    }

</style>