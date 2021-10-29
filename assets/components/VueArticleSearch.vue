<template>
    <article>
        <div class="container-main">
            <vue-fading-lights-animation/>
            <div class="container-ui">
                <div class="title">Pon una ciudad</div>
                <vue-text-search/>
            </div>
        </div>
    </article>
</template>

<script>
import VueTextSearch from './VueTextSearch.vue'
import VueFadingLightsAnimation from './VueFadingLightsAnimation.vue'
    export default {
        name: 'VueArticleSearch',
        components: { VueFadingLightsAnimation, VueTextSearch }
        
    }
</script>

<style lang="scss" scoped>

    .title {
        font-size: 7rem;   
        color: white;  
        text-align: center;
    }

    .container-main {
        display:flex;
        height: 80vh;
        flex-wrap: wrap;
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

</style>