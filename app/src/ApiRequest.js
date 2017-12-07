let ApiRequest = {
    methods: {
        apiRequest: function (url, callback) {

            EventBus.$emit('start-loading');

            this.$http.get(url).then(response => {
                EventBus.$emit('stop-loading', { success: true });
                callback(response.body);
            },
            response => {
                EventBus.$emit('error', response.body);
                EventBus.$emit('stop-loading', { success: false });
            });
        }
    }
};

export default ApiRequest;
