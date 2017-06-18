<template>
    <div id="raspberryies">
        <div v-for="raspberry in raspberries" class="media">
            <div class="media-left">
                <img class="media-object pi-icon" src="/fa-raspberry-pi.svg">
            </div>
            <div class="media-body">
                <h4 class="media-heading">{{ raspberry.hostname }}</h4>
                <div>
                    <i class="fa fa-heartbeat"></i>
                    &nbsp; {{ raspberry.cpu.cores }}x {{ raspberry.cpu.speed }} MHz
                    &#8211; Load: {{ raspberry.load }}
                </div>
                <div>
                    <i class="fa fa-microchip"></i>
                    &nbsp; {{ raspberry.memory.percent }}% RAM
                    &#8211; {{ raspberry.uptime }} Tage Uptime
                    &#8211; {{ raspberry.temperature }} &deg;C
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

</style>


