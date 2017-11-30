<template>
  <v-app class="black white--text" id="app">

    <v-container fluid class="pl-4 pr-4">

      <!-- First row -->
      <v-layout row justify-space-between>
        <v-flex xs8>
          <clock></clock>
        </v-flex>
        <v-flex xs4>
          <temperature></temperature>
        </v-flex>
      </v-layout>

      <!-- Second row -->
      <v-layout row justify-space-between class="pt-5 pb-5">
        <v-flex xs8>
          <calendar></calendar>
        </v-flex>
        <v-flex xs4>
            <weather-forcast class="pb-5"></weather-forcast>
            <petrol class="pt-5"></petrol>
        </v-flex>
      </v-layout>

      <!-- Third row -->
      <v-layout row justify-space-between class="pt-5">
        <v-flex xs8>
          <presence></presence>
        </v-flex>
        <v-flex xs4>
            <raspberries></raspberries>
        </v-flex>
      </v-layout>

        <!-- Bottom row: Fixed to the bottom -->
        <v-footer fixed class="mb-5 black">
          <v-layout row justify-space-between>
            <v-flex xs7 class="pl-3"><news></news></v-flex>
            <v-flex xs5 class="pl-5"><traffic></traffic></v-flex>
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
  overflow: hidden;
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
