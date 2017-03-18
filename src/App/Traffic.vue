<template>
    <div id="traffic">
        <h5 v-for="route in routes">
            <i class="fa fa-car"></i>
            &nbsp; {{ route.duration }} für {{ route.distance }} zur {{ route.destination }}
        </h5>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                routes: null,
            }
        },
        methods: {
            update() {

                this.$http.get('/api.php/traffic').then(response => {
                        ErrorEvent.$emit('reset');
                        this.routes = response.body;
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
    #traffic {
        position: absolute;
        bottom: 20px;
        right: 0;
    }

    h5 {
        font-size: 16px;
        width:     370px;
    }
</style>


