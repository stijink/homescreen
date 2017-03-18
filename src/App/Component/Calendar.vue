<template>
    <table id="calendar">
        <tr v-for="event in events">
            <td>
                <img v-for="person in event.persons" v-bind:src="person['image_url']" width="20" height="20"/>
            </td>
            <td>{{ event.description }}</td>
            <td class="pull-right">{{ event.time }}</td>
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
                api_url: '/api.php/calendar',
                api_update_interval: 10,
                events: null,
            }
        },
        methods: {
            process(data) {
                this.events = data;

                this.events.forEach(function (event, index, events) {
                    let now  = Moment().startOf('day');
                    let eventDate = Moment(event.date);
                    let diffInDays = eventDate.diff(now, 'days');

                    if (diffInDays === 0) {
                        event.time = 'heute';
                    }

                    if (diffInDays === 1) {
                        event.time = 'morgen';
                    }

                    if (diffInDays > 1) {
                        event.time = 'in ' + diffInDays + ' Tagen';
                    }

                    events[index] = event;
                });
            }
        }
    }
</script>

<style scoped>
    #calendar {
        position: absolute;
        top: 200px;
        left: 0;
        width: 400px;
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


