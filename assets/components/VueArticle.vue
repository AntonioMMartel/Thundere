<template>
    <article>
        <div class="container">
            
            <vue-fading-lights-animation/>

        </div>
    </article>
</template>

<script>
import VueFadingLightsAnimation from './VueFadingLightsAnimation.vue'
    export default {
        name: 'VueArticle',
        components: { VueFadingLightsAnimation }
        
    }
</script>

<style lang="scss" scoped>

    .container {
        width: 100%;
        height: 80vh;
    }


</style>