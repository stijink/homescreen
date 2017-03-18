<template>
    <div id="news">
        <div class="story" v-for="story in news" v-show="story.visible">
            <h5>{{ story.title }}</h5>
            <article>{{ story.description }}</article>
        </div>
    </div>
</template>

<script>
    import ApiRequest from '../ApiRequest.js';

    export default {
        mixins: [ApiRequest],
        data() {
            return {
                api_url: '/api.php/news',
                api_update_interval: 5,

                displayForSeconds: 12,
                currentlyOnDisplay: 0,
                news: null,
            }
        },
        methods: {
            update() {
                this.apiRequest(this.api_url, function (data) {
                    this.news = data;
                    this.startNewsRotation();
                }.bind(this));
            },
            startNewsRotation() {

                this.news[0].visible = true;

                setInterval(function () {
                    this.rotateNews();
                }.bind(this), 1000 * this.displayForSeconds);
            },
            rotateNews() {

                // Hide current news article
                this.news[this.currentlyOnDisplay].visible = false;

                this.currentlyOnDisplay++;
                if (this.currentlyOnDisplay === this.news.length) {
                    this.currentlyOnDisplay = 0;
                }

                // Show next article
                this.news[this.currentlyOnDisplay].visible = true;
            }
        },
        mounted() {
            this.update();

            // Make sure the weather is updated every five minutes
            setInterval(function () {
                this.update();
            }.bind(this), 60000 * this.api_update_interval);
        }
    }
</script>

<style scoped>
    .story {
        position: absolute;
        bottom: 20px;
        left: 0;
        width: 400px;
        font-size: 14px;
    }
</style>


