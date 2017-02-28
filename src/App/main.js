import Vue from 'vue';
import VueResource from 'vue-resource';

import App from './App.vue';
import Error from './Error.vue';

import Clock from './Clock.vue';
import Weather from './Weather.vue';
import WeatherForcast from './WeatherForcast.vue';
import Traffic from './Traffic.vue';
import News from './News.vue';
import Calendar from './Calendar.vue';
import Petrol from './Petrol.vue';

Vue.use(VueResource);

// Instance to communicate Errors between components
window.ErrorEvent = new Vue();

Vue.component('error', Error);
Vue.component('clock', Clock);
Vue.component('weather', Weather);
Vue.component('weather-forcast', WeatherForcast);
Vue.component('traffic', Traffic);
Vue.component('news', News);
Vue.component('calendar', Calendar);
Vue.component('petrol', Petrol);

new Vue({
  el: '#app',
  render: h => h(App)
});
