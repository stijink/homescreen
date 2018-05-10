<template>
    <table id="petrol">
        <tr>
            <th class="text-xs-left">
                <v-icon dark class="pr-1">local_gas_station</v-icon>
                {{ location }}
            </th>
        </tr>
        <tr v-for="product in products" :key="product.name">
            <td>{{ product.name }}</td>
            <td class="text-xs-right">{{ product.price }} €</td>
        </tr>
    </table>
</template>

<script>
    import ApiRequest from '../ApiRequest.js';
    import DataUpdater from '../DataUpdater.js';

    export default {
        mixins: [ApiRequest, DataUpdater],
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
            }
        }
    }
</script>

<style scoped>

    table {
        width: 100%;
    }

</style>