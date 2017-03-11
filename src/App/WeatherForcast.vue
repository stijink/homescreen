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
    export default {
        data() {
            return {
                forcast: null,
            }
        },
        methods: {
            update() {

                this.$http.get('/api.php/weather-forcast').then(response => {
                    this.forcast = response.body;

                    this.forcast.forEach(function (day, index, forcast) {
                        day.icon = 'owf-' + day.icon_code;
                        forcast[index] = day;
                    });
                },
                response => {
                    ErrorEvent.$emit('error', response.body);
                });

            }
        },
        mounted() {
            this.update();

            // Make sure the weather is updated every five minutes
            setInterval(function () {
                this.update();
            }.bind(this), 60000 * 5);
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


