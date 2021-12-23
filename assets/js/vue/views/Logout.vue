<template>
    <div>
        If you still havent logged out refresh the page
    </div>
</template>

<script>
export default {
    methods: {
        uili () {
            window.location.replace('/');
        }
    },
    mounted () {
        this.uili();
    }

}
</script>