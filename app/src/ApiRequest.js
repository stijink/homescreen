let ApiRequest = {
    methods: {
        apiRequest: function (url, callback) {
            this.$http.get(url).then(response => {
                ErrorEvent.$emit('reset');
                callback(response.body);
            },
            response => {
                ErrorEvent.$emit('error', response.body);
            });
        }
    }
};

export default ApiRequest;
