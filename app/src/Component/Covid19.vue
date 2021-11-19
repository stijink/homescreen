<template>
    <div id="covid19" class="text-xs-right pr-4">

        <h1 :style="incidenceColor">{{ weekIncidence }}</h1>
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
        computed: {
            incidenceColor: function() {

                if (this.weekIncidence < 4) {
                     return 'color: #ffff6d';
                }

                if (this.weekIncidence < 20) {
                     return 'color: #f6df35';
                }

                if (this.weekIncidence < 50) {
                     return 'color: #cb2e2b';
                }

                if (this.weekIncidence < 100) {
                     return 'color: #920002';
                }

                if (this.weekIncidence < 200) {
                     return 'color: #5e0000';
                }

                if (this.weekIncidence < 400) {
                     return 'color: #400000';
                }

                if (this.weekIncidence < 600) {
                     return 'color: #a84693';
                }

                if (this.weekIncidence < 800) {
                     return 'color: #832b79';
                }

                if (this.weekIncidence < 1000) {
                     return 'color: #611d5a';
                }

                // >= 1000
                return 'color: #41143c';
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


