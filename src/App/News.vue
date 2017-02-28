<template>
    <div id="news">
        <div class="story" v-for="story in news" v-show="story.visible">
            <h5>{{ story.title }}</h5>
            <article>{{ story.description }}</article>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                displayForSeconds: 12,
                currentlyOnDisplay: 0,
                news: null,
            }
        },
        methods: {
            update() {

                this.$http.get('/api.php/news').then(response => {
                    this.news = response.body;
                    this.startNewsRotation();
                },
                response => {
                    ErrorEvent.$emit('error', response.body);
                });
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
            }.bind(this), 60000 * 5);
        }
    }
</script>

<style scoped>
    .story {
        position: absolute;
        bottom: 70px;
        left: 0;
        width: 500px;
        font-size: 14px;
    }
</style>


