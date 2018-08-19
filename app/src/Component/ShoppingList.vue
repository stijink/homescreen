<template>

    <v-container v-if="items.length > 0" fluid grid-list-xs class="ma-0 pa-0 shopping-list">
        <v-layout row wrap>
            <v-flex v-for="item  in items" :key="item.name" xs6>
                <v-list-tile :key="item.name" class="shopping-item">
                    <v-list-tile-avatar size="30" tile="true">
                        <img :src="item.icon" :onerror="alternativeIcon(item)">
                    </v-list-tile-avatar>

                    <v-list-tile-content>
                        <v-list-tile-title v-html="item.name"></v-list-tile-title>
                        <v-list-tile-sub-title>Supermarkt</v-list-tile-sub-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-flex>
        </v-layout>
    </v-container>

</template>

<script>
    import ApiRequest from '../ApiRequest.js';
    import DataUpdater from '../DataUpdater.js';

    export default {
        mixins: [ApiRequest, DataUpdater],
        data() {
            return {
                api_url: '/api.php/shopping-list',
                api_update_interval: 2,

                items: null,
            }
        },
        methods: {
            process(data) {
              this.items = data;
            },
            alternativeIcon(item) {
                return 'this.src="' + item.icon_alternative + '"';
            }
        }
    }
</script>

<style scoped>
    .shopping-list {
        width: 480px;
    }

    .shopping-item {
        height: 55px;
    }
</style>


