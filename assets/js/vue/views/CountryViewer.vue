<template>
    <article>
        <div class="container-main">
            <FadingLightsAnimation/>
            <div class="container-ui">
                <div class="title">Pon una ciudad</div>
                <CountrySearchInput/>
            </div>
        </div>
    </article>
</template>

<script>
import CountrySearchInput from '../components/CountrySearchInput.vue'
import FadingLightsAnimation from '../components/FadingLightsAnimation.vue'
    export default {
        name: 'CountryViewer',
        components: { FadingLightsAnimation, CountrySearchInput }
        
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