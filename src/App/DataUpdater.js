let DataUpdater = {
    methods: {
        update() {
            this.apiRequest(this.api_url, this.process);
        }
    },
    mounted() {
        this.update();

        // Make sure the weather is updated every x minutes
        setInterval(this.update, 60000 * this.api_update_interval);
    }
};

export default DataUpdater;
