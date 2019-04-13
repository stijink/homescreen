import axios from 'axios';

let ApiRequest = {
    methods: {
        apiRequest: function (url, callback) {

            EventBus.$emit('start-loading');

            axios.get(url).then(response => {
                if (response.headers['content-type'] === 'application/json') {
                    EventBus.$emit('stop-loading', { success: true });
                    callback(response.data);
                }
                else {
                    EventBus.$emit('error', '');
                    EventBus.$emit('stop-loading', { success: false });
                }
            })
            .catch (error => {
                EventBus.$emit('error', error.response.data);
                EventBus.$emit('stop-loading', { success: false });
            });
        }
    }
};

export default ApiRequest;
