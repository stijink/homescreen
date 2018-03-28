<template>
    <v-container class="pa-0" id="temperature">
        <v-layout row>
            <v-flex xs7>
                <h2 class="display-3 mb-1" :class="{ 'grey--text text--darken-3' : !has_data }">
                    {{ temperature_outside }} °
                </h2>
                <div>
                    <v-icon dark>terrain</v-icon>
                    Aussentemperatur
                </div>
            </v-flex>

            <v-flex xs5>
                <h2 class="display-3 mb-1" :class="{ 'grey--text text--darken-3' : !has_data }">
                    {{ temperature_inside }} °
                </h2>
                <div>
                    <v-icon dark>home</v-icon>
                    Innentemperatur
                </div>
            </v-flex>

        </v-layout>
    </v-container>
</template>

<script>
    import ApiRequest from '../ApiRequest.js';
    import DataUpdater from '../DataUpdater.js';

    export default {
        mixins: [ApiRequest, DataUpdater],
        data() {
            return {
                api_url: '/api.php/temperature',
                api_update_interval: 2,
                has_data: false,

                temperature_inside: 0,
                temperature_outside: 0,
            }
        },
        methods: {
            process(data) {
                this.has_data = true;
                this.temperature_inside  = data.temperature_inside;
                this.temperature_outside = data.temperature_outside;
            }
        },
    }
</script>
