<template>
    <div id="raspberryies">
        <div v-for="raspberry in raspberries" class="media">
            <div class="media-left">
                <img class="media-object pi-icon" src="/fa-raspberry-pi.svg">
            </div>
            <div class="media-body">
                <h4 class="media-heading">{{ raspberry.hostname }}</h4>

                <!-- CPU / Speed -->
                <div class="mb-1">
                    <v-icon>timeline</v-icon>
                    &nbsp; {{ raspberry.cpu.cores }}x {{ raspberry.cpu.speed }} MHz
                    &#8211; Load: {{ raspberry.load }}
                </div>

                <!-- Memory -->
                <div class="mb-1">
                    <v-icon>memory</v-icon>
                    &nbsp; {{ raspberry.memory.percent }}% RAM
                    &#8211; {{ raspberry.uptime }} Tage Uptime
                    &#8211; {{ raspberry.temperature }} &deg;C
                </div>

                <!-- Disk -->
                <div class="mt-3" v-if="raspberry.disk">
                    <div>
                        <v-icon>storage</v-icon>
                        &nbsp;
                        {{ raspberry.disk.label }}
                        &#8211; {{ raspberry.disk.free }} GB / {{ raspberry.disk.size }} GB available
                    </div>

                    <div class="disk-total">
                        <div class="disk-used" v-bind:style="{ width: raspberry.disk.percent + '%' }"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
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

    .pi-icon {
        -webkit-filter: invert(100%);
        filter: invert(100%);
        width: 43px;
        height: 43px;
        margin-right: 10px;
        margin-left: -6px;
    }

    .media {
        margin-bottom: 30px;
    }

    .media-body {
        font-size: 12px;
    }

    .media-heading {
        font-size: 16px;
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


