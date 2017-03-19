import Vue from 'vue';
import VueResource from 'vue-resource';

import App from './Component/App.vue';
import Error from './Component/Error.vue';

import Clock from './Component/Clock.vue';
import Weather from './Component/Weather.vue';
import WeatherForcast from './Component/WeatherForcast.vue';
import Traffic from './Component/Traffic.vue';
import News from './Component/News.vue';
import Calendar from './Component/Calendar.vue';
import Petrol from './Component/Petrol.vue';
import Presence from './Component/Presence.vue';

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
Vue.component('presence', Presence);

new Vue({
  el: '#app',
  render: h => h(App)
});
