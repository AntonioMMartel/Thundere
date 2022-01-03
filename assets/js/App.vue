<template>
    <body>
        <div>
            <Header :user-role="userRole" />
            <article>
                <RouterView/>
            </article>
            <Footer/>
        </div>
    </body>
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