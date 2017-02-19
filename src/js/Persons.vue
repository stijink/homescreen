<template>
    <div id="persons">
        <person
            v-for="person in persons"
            v-bind:name="person.name"
            v-bind:fbid="person.fbid"
            v-bind:ishome="person.ishome">
        </person>
    </div>
</template>

<script>
    import Person from './Person.vue';

    export default {
        components: {
            'person': Person
        },
        data() {
            return {
                persons: [
                    {name: 'Sigrid', fbid: '599401226', ishome: 'no'},
                    {name: 'Stephan', fbid: '657226131', ishome: 'yes'},
                ]
            }
        }
    }
</script>

<style scoped>
    #persons {
        position: absolute;
        top: 200px;
        left: 0;
    }
</style>


