<template>
    <div id="weather">
        <h1 class="pull-right"><i class="fa fa-thermometer-three-quarters"></i>&nbsp; {{ temperature }} °</h1>
        <h4><i class="owf owf-lg" v-bind:class="icon"></i> {{ description }}</h4>
    </div>
</template>

<script>
    import ApiRequest from '../ApiRequest.js';

    export default {
        mixins: [ApiRequest],
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
            },
            update() {
                this.apiRequest(this.api_url, this.process);
            }
        },
        mounted() {
            this.update();

            // Make sure the weather is updated every five minutes
            setInterval(function () {
                this.update();
            }.bind(this), 60000 * this.api_update_interval);
        }
    }
</script>

<style scoped>
    #weather {
        position: absolute;
        top: 0;
        right: 0;
    }

    h4 {
        position: relative;
    }

    H4>i {
        position: absolute;
        top: 87px;
        left: -42px;
    }
</style>


