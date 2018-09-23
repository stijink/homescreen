import Vue from 'vue';
import VueResource from 'vue-resource';

import Vuetify from 'vuetify'
import '../node_modules/vuetify/dist/vuetify.min.css';

import App from './Component/App.vue';
import Error from './Component/Error.vue';
import LoadingIndicator from './Component/LoadingIndicator.vue';

import Snow from './Component/Snow.vue';

import Clock from './Component/Clock.vue';
import Weather from './Component/Weather.vue';
import Temperature from './Component/Temperature.vue';
import WeatherForcast from './Component/WeatherForcast.vue';
import Traffic from './Component/Traffic.vue';
import News from './Component/News.vue';
import Calendar from './Component/Calendar.vue';
import Petrol from './Component/Petrol.vue';
import Presence from './Component/Presence.vue';
import Raspberries from './Component/Raspberries.vue';
import OpeningHours from './Component/OpeningHours.vue';
import ShoppingList from './Component/ShoppingList.vue';
import Pregnancy from './Component/Pregnancy.vue';


Vue.use(Vuetify);
Vue.use(VueResource);

// Instance to communicate Errors between components
window.EventBus = new Vue();

Vue.component('snow', Snow);
Vue.component('error', Error);
Vue.component('loading-indicator', LoadingIndicator);
Vue.component('clock', Clock);
Vue.component('weather', Weather);
Vue.component('temperature', Temperature);
Vue.component('weather-forcast', WeatherForcast);
Vue.component('traffic', Traffic);
Vue.component('news', News);
Vue.component('calendar', Calendar);
Vue.component('petrol', Petrol);
Vue.component('presence', Presence);
Vue.component('raspberries', Raspberries);
Vue.component('opening-hours', OpeningHours);
Vue.component('shopping-list', ShoppingList);
Vue.component('pregnancy', Pregnancy);

new Vue({
  el: '#app',
  render: h => h(App)
});
