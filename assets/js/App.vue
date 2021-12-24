<template>
    <div>
        <Header :user-role="userRole" />
        <RouterView/>
        <Footer/>
    </div>
</template>

<script>
    import Footer from './vue/components/Footer';
    import Header from './vue/components/Header';

    export default {
        components:{Footer, Header},
        props: ['userRole']
    }
</script>

<style lang="scss" scoped>

</style>