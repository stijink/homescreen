<template>
    <div id="persons">
        <person></person>
    </div>
</template>

<script>
    import Person from './Person.vue';

    export default {
        components: {
            'person': Person
        }
    }
</script>

<style scoped>
    #persons {
        position: absolute;
        top: 200px;
        left: 0;
    }
</style>


