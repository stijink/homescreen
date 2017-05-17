<template>
    <table id="presence">
        <tr v-for="person in presence">
            <td>
                <img v-bind:src="person.person['image_url']"
                     v-bind:class="{ is_present: person.is_present }"
                     width="40"
                     height="40"/>
            </td>
            <td><p v-bind:class="{ is_present: person.is_present }">{{ person.status_text }}</p></td>
        </tr>
    </table>
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
                api_url: '/api.php/presence',
                api_update_interval: 0.5,
                presence: null,
            }
        },
        methods: {
            process(data) {
                this.presence = data;
            }
        }
    }
</script>

<style scoped>
    #presence {
        font-size: 16px;
        margin-left: 3px;
    }

    IMG {
        border-radius: 50%;
        margin-bottom: 7px;
        margin-right: 3px;
        opacity: 0.4;
    }

    IMG.is_present {
        opacity: 0.8;
    }

    P {
        opacity: 0.5;
    }

    P.is_present {
        opacity: 1;
    }

    td:first-child {
        width: 70px;
    }

</style>


