<template>
    <v-container fluid class="pa-0" v-if="raspberries">

        <v-layout row v-for="raspberry in raspberries" :key="raspberry.hostname" class="mb-5">

            <v-flex xs2>
                <img class="pi-icon" src="/fa-raspberry-pi.svg">
            </v-flex>

            <!-- Raspberry is online -->
            <v-flex xs10 class="raspberry-meta-online" v-if="raspberry.is_online === true">
                <h4 class="mb-1">{{ raspberry.hostname }}</h4>
                <h4 v-if="raspberry.description" class="mb-1">"{{ raspberry.description }}"</h4>

                <!-- CPU / Speed -->
                <div class="mb-1">
                    <v-icon dark class="icon mr-1">timeline</v-icon>
                    {{ raspberry.cpu.cores }}x {{ raspberry.cpu.speed }} MHz
                    &#8211; Load: {{ raspberry.load }}
                </div>

                <!-- Memory -->
                <div class="mb-3">
                    <v-icon dark class="icon mr-1">memory</v-icon>
                    {{ raspberry.memory.percent.toFixed(2) }}% RAM
                    &#8211; {{ raspberry.uptime }} Tage Uptime
                    &#8211; {{ raspberry.temperature }} &deg;C
                </div>

                <!-- Disks -->
                <!--
                <div class="mt-1" v-for="disk in raspberry.disks" :key="disk.label">
                    <div>
                        <v-icon dark class="icon mr-1">storage</v-icon>
                        {{ disk.label }}
                        &#8211; {{ disk.free }} GB / {{ disk.size }} GB verfügbar
                    </div>

                    <div class="disk-total">
                        <div class="disk-used" v-bind:style="{ width: disk.percent + '%' }"></div>
                    </div>

                </div>
                -->
            </v-flex>

            <!-- Raspberry is offline -->
            <v-flex xs10 class="raspberry-meta-offline" v-if="raspberry.is_online === false">
                <h4 class="mb-1">{{ raspberry.hostname }}</h4>
                <h4 v-if="raspberry.description" class="mb-1">"{{ raspberry.description }}"</h4>

                <div class="mb-1">
                    <v-icon dark class="icon mr-1">warning</v-icon>
                    Das Gerät ist zur Zeit nicht erreichbar
                </div>

            </v-flex>

        </v-layout>
    </v-container>
</template>

<script>
    import ApiRequest from '../ApiRequest.js';
    import DataUpdater from '../DataUpdater.js';

    import Moment from 'moment';
    Moment.locale('de');

    export default {
        mixins: [ApiRequest, DataUpdater],
        data() {
            return {
                api_url: '/api.php/raspberries',
                api_update_interval: 2,
                raspberries: null,
            }
        },
        methods: {
            process(data) {
                this.raspberries = data;
            }
        }
    }
</script>

<style scoped>

    .icon {
        font-size: 1.0rem;
    }

    h4 {
        font-size: 1.0rem;
    }

    .raspberry-meta-online {
        font-size: 0.85rem;
    }

    .raspberry-meta-offline {
        font-size: 1rem;
    }

    .pi-icon {
        -webkit-filter: invert(100%);
        filter: invert(100%);
        width: 43px;
        height: 43px;
        margin-right: 10px;
        margin-left: -6px;
    }

    .disk-total {
        background-color: #333333;
        width: 210px;
        display: inline-block;
    }

    .disk-used {
        background-color: #666666;
        height:10px;
    }

</style>


