<template>

    <v-container v-if="data" fluid class="pregnancy pa-0 text-xs-center">
        <v-layout row>

            <v-flex xs4>
                <v-progress-circular :value="percentage" width="7" size="120" rotate="-90" color="white" class="mt-4">
                    <p class="title percentage">{{ percentage }}%</p>
                </v-progress-circular>
            </v-flex>

            <v-flex xs8>
                <table>
                    <tr class="display-3">
                        <td>{{ data.days_since }}</td>
                        <td>{{ data.weeks_since }}</td>
                        <td>{{ data.months_since }}</td>
                    </tr>
                    <tr>
                        <td>Tag</td>
                        <td>Woche</td>
                        <td>Monat</td>
                    </tr>
                </table>

                <p class="subheading pt-4">
                    Noch {{ data.weeks_until }} Wochen bis zum {{ data.date_expected }}
                </p>
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
                api_url: '/api.php/pregnancy',
                api_update_interval: 10,
                data: null,
            }
        },

        methods: {
            process(data) {
                this.data = data;
            }
        },

        computed: {
            percentage() {
                if (this.data === null) {
                    return 0;
                }

                return (this.data.days_since * 100 / 280).toFixed(0);
            }
        },
    }
</script>

<style scoped>

    .pregnancy {
        width: 480px;
        margin: 0;
    }

    >>> .v-progress-circular__underlay {
        stroke: #3c3c3c;
    }

    .percentage {
        margin-top: 15px;
    }

    table {
        width: 100%;
    }

    td {
        min-width: 100px;
    }

</style>