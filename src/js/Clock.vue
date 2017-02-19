<template>
    <div id="clock">
        <h3>{{ day }}, {{ date }} </h3>
        <h1>{{ time }} Uhr</h1>
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
            updateDateTime() {
                this.day  = Moment().format('dddd');
                this.date = Moment().format('Do MMMM YYYY');
                this.time = Moment().format('hh:mm:ss');
            }
        },
        mounted() {
            this.updateDateTime();

            // Make sure the time is updated every second
            setInterval(function () {
                this.updateDateTime();
            }.bind(this), 1000);
        }
    }
</script>

<style scoped>
    #clock {
        position: absolute;
        top: 0;
        left: 0;
    }
</style>


