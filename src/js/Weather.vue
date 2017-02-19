<template>
    <div id="weather">
        <h1><i class="fa fa-thermometer-three-quarters"></i>&nbsp; {{ temperature }} °</h1>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                temperature: 5
            }
        }
    }
</script>

<style scoped>
    #weather {
        position: absolute;
        top: 0;
        right: 0;
    }
</style>


