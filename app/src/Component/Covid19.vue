<template>
    <div id="covid19" class="text-xs-right pr-4">

        <h1>{{ weekIncidence }}</h1>
        <strong>Covid 19 Inzidenz für den {{ location }} </strong>

    </div>
</template>

<script>
    import ApiRequest from '../ApiRequest.js';
    import DataUpdater from '../DataUpdater.js';

    export default {
        mixins: [ApiRequest, DataUpdater],
        data() {
            return {
                api_url: '/api.php/covid19',
                api_update_interval: 60,

                location: null,
                weekIncidence: null,
            }
        },
        methods: {
            process(data) {
                this.location = data.name;
                this.weekIncidence = Math.round(data.weekIncidence);
            }
        }
    }
</script>

<style scoped>



</style>


