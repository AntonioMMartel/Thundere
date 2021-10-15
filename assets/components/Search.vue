<template> 
<p>"Hello world"</p>

</template>

<script lang="ts">

export default {

    data () {
        return {
            texto: "Hola que tal"
        }
    },
    computed: {
        reversedSaludo () {
            return this.message.split('').reverse().join('')
        }
    }
}    
</script>


<style lang="sass" scoped>
p
    font-size 2em;
    text-align center;
</style>

