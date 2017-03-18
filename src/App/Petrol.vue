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
    export default {
        data() {
            return {
                location: null,
                products: null
            }
        },
        methods: {
            update() {

                this.$http.get('/api.php/petrol').then(response => {
                    ErrorEvent.$emit('reset');
                    this.location = response.body.location;
                    this.products = response.body.products;
                },
                response => {
                    ErrorEvent.$emit('error', response.body);
                });
            }
        },
        mounted() {
            this.update();

            // Make sure the data is updated every 10 Minutes
            setInterval(function () {
                this.update();
            }.bind(this), 60000 * 10);
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


