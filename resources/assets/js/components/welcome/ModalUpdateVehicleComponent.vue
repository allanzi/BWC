<template>
    <div class="root">

    </div>
</template>

<script>
    export default {
        data() {
            return {
                id: '',
                name: '',
                brand: '',
                year: '',
                has_sold: '',
                description: ''
            }
        },
        mounted() {
            EventBus.$on('clickedUpdateModal', (dataPassed) => console.log(dataPassed));
        },

    }
</script>

<style scoped>
    div.root {
        display: inline-block;
    }
</style>