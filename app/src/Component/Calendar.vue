<template>
    <table id="calendar">
        <tr v-for="event in events">
            <td valign="middle">
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
                api_update_interval: 2,
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
        font-size:   16px;
        min-height:  300px;
        margin-left: 3px;
        width:       450px;
    }

    IMG {
        border-radius: 50%;
        margin-right: 3px;
    }

    /* Person Icons */
    td:first-child {
        width: 70px;
    }

    /* Date */
    td:nth-child(3) {
        width: 80px;
    }

</style>


