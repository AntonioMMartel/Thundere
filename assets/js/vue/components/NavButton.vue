<template>
        <router-link :to="href" class="contenedor-nav-item"> {{ label }} </router-link>
</template>

<script>
    export default {
        props: ['label','href','user-role']
    }
</script>

<style lang="scss" scoped>

    .contenedor-nav-item {
        padding: 1.25em;
        text-decoration: none;
        color:$primary-color;

        &:hover{
            color:$primary-color-darker
        }

    }

    
</style>