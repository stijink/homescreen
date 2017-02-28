<template>
    <div id="weather">
        <h1 class="pull-right"><i class="fa fa-thermometer-three-quarters"></i>&nbsp; {{ temperature }} °</h1>
        <h4><i v-bind:class="icon"></i> {{ description }}</h4>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                temperature: null,
                description: null,
                icon: null,
            }
        },
        methods: {
            update() {

                this.$http.get('/api.php/weather').then(response => {
                    this.temperature = response.body.temperature;
                    this.description = response.body.description;
                    this.icon = response.body.icon;
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
    #weather {
        position: absolute;
        top: 0;
        right: 0;
    }

    h4 {
        position: relative;
    }

    H4>i {
        position: absolute;
        top: 74px;
        left: -42px;
    }
</style>


