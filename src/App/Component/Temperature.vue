<template>
    <v-container class="pa-0" id="temperature">

        <v-layout row>

            <v-flex xs6 class="text-xs-right">
                <h2>{{ temperature_outside }} °</h2>
                <div>
                    <v-icon>terrain</v-icon>
                    Aussentemperatur
                </div>
            </v-flex>

            <v-flex xs6 class="text-xs-right">
                <h2>{{ temperature_inside }} °</h2>
            </v-flex>

        </v-layout>

        <!--<tr>-->
            <!--<td><span class="temperature-outside"></span></td>-->
            <!--<td><span class="temperature-inside">{{ temperature_inside }} °</span></td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>-->
                <!--<v-icon>terrain</v-icon>-->
                <!--&nbsp; Aussentemperatur-->
            <!--</td>-->
            <!--<td>-->
                <!--<v-icon>home</v-icon>-->
                <!--&nbsp; Innentemperatur-->
            <!--</td>-->
        <!--</tr>-->
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

                temperature_inside: null,
                temperature_outside: null,
            }
        },
        methods: {
            process(data) {
                this.temperature_inside  = data.temperature_inside;
                this.temperature_outside = data.temperature_outside;
            }
        },
    }
</script>
