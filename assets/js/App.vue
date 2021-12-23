<template>
    <div>
        <Header :user-role="userRole" />
        <RouterView/>
        <Footer/>
    </div>
</template>

<script>
    import CountrySearchInput from './vue/components/CountrySearchInput';
    import FadingLightsAnimation from './vue/components/FadingLightsAnimation';
    import Footer from './vue/components/Footer';
    import Header from './vue/components/Header';
    import NavButton from './vue/components/NavButton';

    export default {
        components:{CountrySearchInput, FadingLightsAnimation, Footer, Header, NavButton },
        props: ['userRole']
    }
</script>

<style lang="scss" scoped>

</style>