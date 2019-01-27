<template>
  <v-app class="black white--text" id="app">

    <v-container fluid class="pl-4 pr-4">

      <!-- Top row -->
      <v-layout row justify-space-between class="spacing-bottom">
        <v-flex xs8>
          <clock></clock>
        </v-flex>
        <v-flex xs4>
          <temperature></temperature>
        </v-flex>
      </v-layout>

      <!-- Middle row -->
      <v-layout row justify-space-between>

        <v-flex xs8>

          <pregnancy class="spacing-bottom"></pregnancy>
          <calendar class="spacing-bottom-2x"></calendar>
          <shopping-list class="spacing-bottom"></shopping-list>
          <presence></presence>
        </v-flex>

        <v-flex xs4>
            <weather-forcast class="spacing-bottom"></weather-forcast>
            <opening-hours class="spacing-bottom"></opening-hours>
            <petrol class="spacing-bottom-2x"></petrol>
            <raspberries></raspberries>
        </v-flex>

      </v-layout>

        <!-- Bottom row: Fixed to the bottom -->
        <v-footer fixed class="mb-5 black white--text">
          <v-layout row justify-space-between class="mb-5">
            <v-flex xs8 class="ml-3"><news></news></v-flex>
            <!-- <v-flex xs4><traffic></traffic></v-flex> -->
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

.v-icon {
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

.spacing-bottom {
  margin-bottom: 72px !important;
}

.spacing-bottom-2x {
  margin-bottom: 120px !important;
}

</style>
