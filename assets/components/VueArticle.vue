<template>
    <article>
        <div class="container-main">
            <vue-fading-lights-animation/>
            <div class="container-ui">
                <div class="title">Pon una ciudad</div>
                <vue-city-search/>
            </div>
        </div>
    </article>
</template>

<script>
import VueCitySearch from './VueCitySearch.vue'
import VueFadingLightsAnimation from './VueFadingLightsAnimation.vue'
    export default {
        name: 'VueArticle',
        components: { VueFadingLightsAnimation, VueCitySearch }
        
    }
</script>

<style lang="scss" scoped>

    .title {
        font-size: 9em;   
        color: $primary-color;     
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
        justify-content: center;
        align-items: center;
        
    }

</style>