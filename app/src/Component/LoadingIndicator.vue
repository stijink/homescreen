<template>
    <v-progress-circular
        indeterminate
        :color="indicatorColor"
        v-if="isLoading">
    </v-progress-circular>
</template>

<script>
    export default {
        data() {
            return {
                isLoading: true,
                indicatorColor: 'white',
            }
        },
        methods: {
            stopLoading(payload) {
                // If the request was successful color the indicator green for a bit
                if (payload.success === true) {
                    this.indicatorColor = 'green';
                }

                // If the request was not successful color the indicator red for a bit
                if (payload.success === false) {
                    this.indicatorColor = 'red';
                }

                setTimeout(this.resetIndicator, 1000);
            },

            resetIndicator() {
                this.isLoading = false;
                this.indicatorColor = 'white';
            }
        },
        mounted() {

            EventBus.$on('start-loading', function () {
                this.isLoading = true;
            }.bind(this));

            EventBus.$on('stop-loading', function (payload) {
                // Stop loading after a brief delay
                setTimeout(this.stopLoading, 1000, payload);
            }.bind(this));
        }
    }
</script>

<style scoped>

</style>
