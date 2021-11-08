<template>
        <header>
            <nav class="contenedor-nav">
                <!-- Te haces un controlador pa los hrefs: 
                https://symfony.com/doc/current/routing.html#creating-routes-as-attributes-or-annotations -->
                <a href="./" class="contenedor-nav-item nav-text">History</a>
                <div class="contenedor-nav-item nav-text">Logo</div>
                <a class="contenedor-nav-item nav-text">Bookmarks</a>
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