<template>
    <div id="person">
        <img v-bind:src="imageUrl">
        <h4>{{ message }}</h4>
    </div>
</template>

<script>
    export default {
        props: ['name', 'fbid', 'ishome'],
        computed: {
            imageUrl() {
                return 'http://graph.facebook.com/' + this.fbid + '/picture?type=large&width=50&height=50';
            },
            message() {
                if (this.ishome === 'yes') {
                    return this.name + ' ist zuhause';
                }

                return this.name + ' ist nicht zuhause';
            }
        }
    }
</script>

<style scoped>
    #person {
        padding-bottom: 10px;
    }

    IMG {
        border-radius: 50%;
        margin-bottom: 10px;
        margin-right: 20px;
    }

    H4 {
        float: right;
        margin: 11px 0 0 0;
    }
</style>


