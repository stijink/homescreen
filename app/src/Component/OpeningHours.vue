<template>

    <v-container fluid class="pa-0">
        <h4>Öffnungszeiten</h4>
        <table>
            <tr v-for="place in places" :key="place.name">
                <td><v-icon dark>{{ choose_icon(place) }}</v-icon></td>
                <td>{{ place.name }}</td>
                <td class="text-xs-right">{{ place.hours }}</td>
            </tr>
        </table>
    </v-container>

</template>

<script>
    import ApiRequest from '../ApiRequest.js';
    import DataUpdater from '../DataUpdater.js';

    export default {
        mixins: [ApiRequest, DataUpdater],
        data() {
            return {
                api_url: '/api.php/opening-hours',
                api_update_interval: 5,

                places: null,
            }
        },
        methods: {
            process(data) {
              this.places = data;
            },
            choose_icon(place) {
                if (place.is_open === true) {
                    return 'alarm_on'
                }

                return 'alarm_off'
            }
        }
    }
</script>

<style scoped>

    table {
        width: 100%;
    }

</style>


