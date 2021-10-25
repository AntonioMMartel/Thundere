<template>
        <header>
            <nav class="contenedor-nav">
                <div class="contenedor-nav-item">History</div>
                <div class="contenedor-nav-item">Logo</div>
                <div class="contenedor-nav-item">Bookmarks</div>
            </nav>
        </header>
</template>

<script>
    export default {
        name: 'header1'
    }
</script>

<style scoped>

    .contenedor-nav{
        display: flex;
        width: 100%;
        height: 7vh;
        justify-content: center;
        align-items: center;
        background: #00235c;
        color: white;
    }

    .contenedor-nav-item {

        padding: 1em;

    }

</style>