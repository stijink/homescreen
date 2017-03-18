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
    #clock {
        position: absolute;
        top: 0;
        left: 0;
    }

    H3 {
        font-size: 3rem;
    }

    h1 {
        font-size: 4.5rem;
    }
</style>


