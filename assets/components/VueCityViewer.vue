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
    .container-ui {
            width: 100%;
            height: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
    }
</style>