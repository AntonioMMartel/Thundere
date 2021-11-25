<template>
        <header>
            <nav class="contenedor-nav">
                <a href="./" class="contenedor-nav-item">History</a>
                <a href="./" class="contenedor-nav-item">Bookmarks</a>
                <a href="./login" class="contenedor-nav-item">Login</a>            
            </nav>
        </header>
</template>

<script>
    export default {
        name: 'VueHeader'
    }
</script>

<style lang="scss" scoped>

    .contenedor-nav{
        display: flex;
        width: 100%;
        height: 10vh;
        justify-content: center;
        align-items: center;
        color: $primary-color;

        font-size: 2em;
    }

    .contenedor-nav-item {

        padding: 1em;

    }


</style>