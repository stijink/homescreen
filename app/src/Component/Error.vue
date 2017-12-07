<template>
    <v-snackbar color="error" bottom v-model="hasError" multi-line>
        <div>{{ message }}</div>
    </v-snackbar>
</template>

<script>
    export default {
        data() {
            return {
                timeout: 20000,
                message: null,
                hasError: false,
            }
        },
        methods: {
            resetError() {
                this.message = null;
                this.hasError = false;
            }
        },
        mounted() {
            EventBus.$on('error', function (response) {
                this.message  = response.message;
                this.hasError = true;
                setTimeout(this.resetError, this.timeout)
            }.bind(this));
        }
    }
</script>

<style scoped>

    div {
        font-size: 1.2rem;
    }

</style>
