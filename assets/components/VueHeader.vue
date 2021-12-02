<template>
    <nav class="contenedor-nav">
        <vue-nav-button
        v-for="navButton in navButtonsDisplay"
        :key="navButton.id"
        :label="navButton.label"
        :href="navButton.href"
        ></vue-nav-button>            
    </nav>
</template>

<script>
import VueNavButton from './VueNavButton.vue'
    export default {
        name: 'VueHeader',
        data: () => ({
            navButtons: [
                {id: 1, label: "History", href:"/history", forRole:"user" },
                {id: 2, label: "Sign in", href:"/login", forRole:"none" },
                {id: 3, label: "Home", href:"/", forRole:"all" },
                {id: 4, label: "Bookmarks", href:"/bookmarks", forRole:"user" },
                {id: 5, label: "Sign up", href:"/register", forRole:"none" },
            ],
        }),
        methods: {
            
        },
        components: { VueNavButton },
        props:["userRole"],
        computed: {
            navButtonsDisplay: function() {
                let navButtonsRole = [];
                // Mira si el botón está destinado a ese usuario. Si no lo está lo quita
                for(let key in this.navButtons) {
                    if (this.navButtons[key].forRole == this.userRole || this.navButtons[key].forRole == "all"){
                        navButtonsRole.push(this.navButtons[key]);
                    } 
                }
                return navButtonsRole;
            }
        }

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



</style>