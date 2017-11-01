<template>
    <div id="traffic">
        <h5 v-for="route in routes">
            <v-icon class="mr-1">directions_car</v-icon>
            {{ route.duration }} für {{ route.distance }} zur {{ route.destination }}
        </h5>
    </div>
</template>

<script>
    import ApiRequest from '../ApiRequest.js';
    import DataUpdater from '../DataUpdater.js';

    export default {
        mixins: [ApiRequest, DataUpdater],
        data() {
            return {
                api_url: '/api.php/traffic',
                api_update_interval: 5,

                routes: null,
            }
        },
        methods: {
            process(data) {
              this.routes = data;
            }
        }
    }
</script>

<style scoped>

    h5 {
        font-size: 16px;
        width:     370px;
    }
</style>


