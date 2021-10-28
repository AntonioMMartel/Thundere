<template>
        <header>
            <nav class="contenedor-nav">
                <div class="contenedor-nav-item nav-text">History</div>
                <div class="contenedor-nav-item nav-text">Logo</div>
                <div class="contenedor-nav-item nav-text">Bookmarks</div>
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
    }

    .contenedor-nav-item {

        padding: 1em;

    }

    .nav-text {

        font-size: 2em;
        
    }

</style>