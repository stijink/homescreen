<template>
    <div id="weather">
        <h1 class="pull-right"><i class="fa fa-thermometer-three-quarters"></i>&nbsp; {{ temperature }} °</h1>
        <h4><i class="owf owf-lg" v-bind:class="icon"></i> {{ description }}</h4>
    </div>
</template>

<script>
    import ApiRequest from '../ApiRequest.js';
    import DataUpdater from '../DataUpdater.js';

    export default {
        mixins: [ApiRequest, DataUpdater],
        data() {
            return {
                api_url: '/api.php/weather',
                api_update_interval: 5,

                temperature: null,
                description: null,
                icon: null,
            }
        },
        methods: {
            process(data) {
                this.temperature = data.temperature;
                this.description = data.description;
                this.icon = 'owf-' + data.icon_code;
            }
        }
    }
</script>

<style scoped>

    h4 {
        position: relative;
    }

    H4>i {
        position: absolute;
        top: 87px;
        left: -42px;
    }
</style>


