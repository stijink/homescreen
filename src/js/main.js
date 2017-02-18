import Vue from 'vue';
import App from './App.vue';
import Clock from './Clock.vue';
import Weather from './Weather.vue';
import Persons from './Persons.vue';

Vue.component('clock', Clock);
Vue.component('weather', Weather);
Vue.component('persons', Persons);

new Vue({
  el: '#app',
  render: h => h(App)
})
