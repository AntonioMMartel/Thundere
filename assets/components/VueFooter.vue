<template>
    <footer class="contenedor-footer">
        <div class="footer-text">©2021 Gofio SA ™ - Todos los derechos reservados</div>
    </footer>
</template>

<script>
    export default {
        name: 'VueFooter'
    } 
</script>

<style lang="scss" scoped>
    .contenedor-footer{
        display: flex;
        flex-direction: column-reverse;
        width: 100%;
        align-items: center;
        
        height: 10vh;
    }

    .footer-text {
        color: white; 
        padding: 1em;
    }
</style>