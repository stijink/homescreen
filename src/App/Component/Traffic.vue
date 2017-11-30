<template>

    <v-container fluid class="pa-0">
        <h5 v-for="route in routes" :key="route.destination">
            <v-icon dark class="mr-1">directions_car</v-icon>
            {{ route.duration }} für {{ route.distance }} zur {{ route.destination }}
        </h5>
    </v-container>

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
        font-size: 14px;
        font-weight: normal;
        line-height: 2rem;
        margin: 0;
    }
</style>


