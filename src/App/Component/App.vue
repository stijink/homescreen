<template>
  <v-app class="black white--text" id="app">

    <v-container fluid class="pl-4 pr-4">

      <!-- First row -->
      <v-layout row justify-space-between>
        <v-flex xs6><clock></clock></v-flex>
        <v-flex xs6><temperature></temperature></v-flex>
      </v-layout>

        <!-- <div class="row row-2">
          <div class="col-md-6 col-left width-400">
            <calendar></calendar>
          </div>
          <div class="col-md-6 col-right width-400">
            <weather-forcast></weather-forcast>
            <petrol></petrol>
          </div>
        </div>

        <div class="row row-3">
          <div class="col-md-6 col-left width-400">
            <presence></presence>
          </div>
          <div class="col-md-6 col-right width-400">
            &nbsp;<raspberries></raspberries>
          </div>
        </div> -->

        <!-- Bottom row: Fixed to the bottom -->
        <v-footer fixed class="mb-3 black pl-4 pr-4">
          <v-layout row justify-space-between>
            <v-flex xs6><news></news></v-flex>
            <v-flex xs5 offset-xs-1><traffic></traffic></v-flex>
          </v-layout>
        </v-footer>

    </v-container>

    <error></error>

  </v-app>

</template>

<style>

html, body {
  font-family: 'Roboto Condensed', sans-serif;
  height: 100%;
}

.icon {
    font-size: 1.3rem;
}

H3 {
  font-size: 3rem;
}

h1 {
  font-size: 4.5rem;
}

</style>
