<template>
    <div id="traffic">
        <h5 v-for="route in routes">
            <i class="fa fa-car"></i>
            &nbsp; {{ route.duration }} für {{ route.distance }} zur {{ route.destination }}
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
    #traffic {
        position: absolute;
        bottom: 20px;
        right: 0;
    }

    h5 {
        font-size: 16px;
        width:     370px;
    }
</style>


