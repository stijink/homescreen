<template>
    <div id="clock">
        <div class="date">{{ day }}, {{ date }}</div>
        <div class="time">{{ time }} Uhr</div>
    </div>
</template>

<script>

    import Moment from 'moment';
    Moment.locale('de');

    export default {
        data() {
            return {
                day: null,
                date: null,
                time: null,
            }
        },
        methods: {
            update() {
                this.day  = Moment().format('dddd');
                this.date = Moment().format('Do MMMM YYYY');
                this.time = Moment().format('HH:mm:ss');
            }
        },
        mounted() {
            this.update();

            // Make sure the time is updated every second
            setInterval(function () {
                this.update();
            }.bind(this), 1000);
        }
    }
</script>

<style scoped>
    .date {
        font-size: 2.5rem;
    }

    .time {
        font-size: 3.1rem;
        line-height: 1.0;
    }
</style>


