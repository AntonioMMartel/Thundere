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
        name: 'Home',
        components: { FadingLightsAnimation, CountrySearchInput }
        
    }
</script>

<style lang="scss" scoped>

    .title {
        font-size: 7rem;     
        text-align: center;
    }

    .container-main {
        display:flex;
        height: 80vh;
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

</style>