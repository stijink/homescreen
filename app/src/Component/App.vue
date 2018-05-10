<template>
  <v-app class="black white--text" id="app">

    <v-container fluid class="pl-4 pr-4">

      <!-- Top row -->
      <v-layout row justify-space-between class="pb-4">
        <v-flex xs8>
          <clock></clock>
        </v-flex>
        <v-flex xs4>
          <temperature></temperature>
        </v-flex>
      </v-layout>

      <!-- Middle row -->
      <v-layout row justify-space-between class="pt-5 pb-5">

        <v-flex xs8>
          <calendar class="pb-5"></calendar>
          <presence class="pt-2"></presence>
        </v-flex>

        <v-flex xs4>
            <weather-forcast class="pb-5"></weather-forcast>
            <opening-hours class="pt-3 pb-3"></opening-hours>
            <petrol class="pb-5 pt-5"></petrol>
            <raspberries class="pt-5"></raspberries>
        </v-flex>

      </v-layout>

        <!-- Bottom row: Fixed to the bottom -->
        <v-footer fixed class="mb-5 black white--text">
          <v-layout row justify-space-between class="mb-5">
            <v-flex xs8 class="ml-3"><news></news></v-flex>
            <v-flex xs4><traffic></traffic></v-flex>
          </v-layout>
        </v-footer>

    </v-container>

    <error></error>
    <loading-indicator id="loading-indicator"></loading-indicator>

  </v-app>

</template>

<style>

html, body {
  height: 100%;
  overflow: hidden;
}

html, body, .application {
  font-family: 'Roboto Condensed', sans-serif;
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

#loading-indicator {
  z-index: 12;
  position: absolute;
  bottom: 20px;
  right: 20px;
}

</style>
