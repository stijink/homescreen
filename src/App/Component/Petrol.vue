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

