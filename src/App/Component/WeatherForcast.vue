<template>
    <table id="weather-forcast">
        <tr v-for="day in forcast">
            <td><i class="owf owf-lg" v-bind:class="day.icon"></i></td>
            <td>{{ day.day }}</td>
            <td>{{ day.description }}</td>
            <td class="pull-right">{{ day.temperature }} °</td>
        </tr>
    </table>
</template>

<script>
    import ApiRequest from '../ApiRequest.js';
    import DataUpdater from '../DataUpdater.js';

    export default {
        mixins: [ApiRequest, DataUpdater],
        data() {
            return {
                api_url: '/api.php/weather-forcast',
                api_update_interval: 5,

                forcast: null,
            }
        },
        methods: {
            process(data) {
                this.forcast = data;

                this.forcast.forEach(function (day, index, forcast) {
                    day.icon = 'owf-' + day.icon_code;
                    forcast[index] = day;
                });
            }
        }
    }
</script>

<style scoped>

    TABLE {
        position: absolute;
        top: 200px;
        right: 0;
        width: 370px;
    }

    td {
        position: relative;
    }

    td:first-child {
        width: 30px;
    }

    i {
        position: absolute;
        top: 7px;
        left: 0px;
    }
</style>


