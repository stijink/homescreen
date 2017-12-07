<template>
    <div id="news">
        <div class="story" v-for="story in news" v-show="story.visible">
            <h5 class="headline mb-2">{{ story.title }}</h5>
            <article>{{ story.description }}</article>
        </div>
    </div>
</template>

<script>
    import ApiRequest from '../ApiRequest.js';
    import DataUpdater from '../DataUpdater.js';

    export default {
        mixins: [ApiRequest, DataUpdater],
        data() {
            return {
                api_url: '/api.php/news',
                api_update_interval: 5,

                displayForSeconds: 15,
                currentlyOnDisplay: 0,
                rotationInterval: null,
                news: null,
            }
        },
        methods: {
            process(data) {
                this.news = data;

                // Make first article visible
                this.news[0].visible = true;

                // Reset the news display iteratior
                this.currentlyOnDisplay = 0;

                // Stop the current interval for news rotation
                clearInterval(this.rotationInterval);

                // Start/Restart news rotation
                this.rotationInterval = setInterval(function () {
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
        }
    }
</script>

<style scoped>

    #news {
        max-width: 550px;
    }

    .story {
        font-size: 15px;
    }

</style>


