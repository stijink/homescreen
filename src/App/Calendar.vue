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

    import Moment from 'moment';
    Moment.locale('de');

    export default {
        data() {
            return {
                events: null,
            }
        },
        methods: {
            update() {

                this.$http.get('/api.php/calendar').then(response => {
                    this.events = response.body;

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
                },
                response => {
                    ErrorEvent.$emit('error', response.body);
                });
            },
        },
        mounted() {
            this.update();

            // Make sure the calendar is updated every 60 minutes
            setInterval(function () {
                this.update();
            }.bind(this), 60000 * 60);
        }
    }
</script>

<style scoped>
    #calendar {
        position: absolute;
        top: 145px;
        left: 0;
        width: 500px;
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


