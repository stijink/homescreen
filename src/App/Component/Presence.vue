<template>
    <table id="presence">
        <tr v-for="person in presence">
            <td>
                <img v-bind:src="person.person['image_url']" width="40" height="40"/>
            </td>
            <td v-if="person.is_present">{{ person.person.name }} <strong>ist zuhause</strong></td>
            <td v-else="">{{ person.person.name }} ist nicht zuhause</td>
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
                api_update_interval: 10,
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
    }

    IMG {
        border-radius: 50%;
        margin-bottom: 7px;
        margin-right: 3px;
    }

    td:first-child {
        width: 70px;
    }

</style>


