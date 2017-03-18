<template>
    <table id="petrol">
        <tr>
            <th><i class="fa fa-tachometer"></i> &nbsp;{{ location }}</th>
        </tr>
        <tr v-for="product in products">
            <td>{{ product.name }}</td>
            <td class="pull-right">{{ product.price }} €</td>
        </tr>
    </table>
</template>

<script>
    import ApiRequest from '../ApiRequest.js';

    export default {
        mixins: [ApiRequest],
        data() {
            return {
                api_url: '/api.php/petrol',
                api_update_interval: 10,

                location: null,
                products: null
            }
        },
        methods: {
            process(data) {
                this.location = data.location;
                this.products = data.products;
            },
            update() {
                this.apiRequest(this.api_url, this.process);
            }
        },
        mounted() {
            this.update();

            // Make sure the data is updated every 10 Minutes
            setInterval(function () {
                this.update();
            }.bind(this), 60000 * this.api_update_interval);
        }
    }
</script>

<style scoped>
    TABLE {
        position: absolute;
        top: 410px;
        right: 0;
        width: 370px;
    }
</style>


