<template>
    <table id="temperature">
        <tr>
            <td><span class="temperature-outside">{{ temperature_outside }} °</span></td>
            <td><span class="temperature-inside">{{ temperature_inside }} °</span></td>
        </tr>
        <tr>
            <td>
                <i class="fa fa-thermometer-half"></i>
                &nbsp; Aussentemperatur
            </td>
            <td>
                <i class="fa fa-home"></i>
                &nbsp; Innentemperatur
            </td>
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
                api_url: '/api/temperature',
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

<style scoped>

    #temperature {
        margin-top: 8px;
    }

    .temperature-outside {
        font-size: 5.0rem;
        line-height: 1.0;
    }

    .temperature-inside {
        font-size: 4.3rem;
        line-height: 1.0;
    }

    td {
        font-size: 18px;
        text-align: left;
    }

    tr td:first-child {
        padding-right: 40px;
    }

    tr:nth-child(2) {
        margin-top: -10px;
    }

</style>
