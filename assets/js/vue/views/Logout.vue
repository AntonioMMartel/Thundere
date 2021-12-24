<template>
    <article>
        <div class="container-main">

            Iconito / Gif crema de cargando
            
        </div>
    </article>
</template>

<script>
export default {
    created () {
        window.location.reload()
    }
}
</script>

<style lang="scss" scoped>
.container-main {
    display:flex;
    align-items: center;
    justify-content: center;
    height: 80vh;
    flex-wrap: wrap;
    color: $primary-color;
}
</style>