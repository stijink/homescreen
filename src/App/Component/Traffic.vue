<template>
    <div id="traffic">
        <h5 v-for="route in routes">
            <i class="fa fa-car"></i>
            &nbsp; {{ route.duration }} für {{ route.distance }} zur {{ route.destination }}
        </h5>
    </div>
</template>

<script>
    import ApiRequest from '../ApiRequest.js';

    export default {
        mixins: [ApiRequest],
        data() {
            return {
                api_url: '/api.php/traffic',
                api_update_interval: 5,

                routes: null,
            }
        },
        methods: {
            update() {
                this.apiRequest(this.api_url, function (data) {
                    this.routes = data;
                }.bind(this));
            }
        },
        mounted() {
            this.update();

            // Make sure the weather is updated every five minutes
            setInterval(function () {
                this.update();
            }.bind(this), 60000 * this.api_update_interval);
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


