<template>
  <div id="app" class="container-fluid">

    <error></error>

    <div class="row row-1">
      <div class="col-md-6 col-left">
        <clock></clock>
      </div>
      <div class="col-md-6 col-right">
        <weather></weather>
      </div>
    </div>

    <div class="row row-2">
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
        &nbsp;
      </div>
    </div>

    <!-- Bottom row: Fixed to the bottom -->

    <div class="row row-bottom width-400">
      <div class="col-md-6 col-left">
        <news></news>
      </div>
      <div class="col-md-6 col-right width-400">
        <traffic></traffic>
      </div>
    </div>

  </div>
</template>

<style>

body {
  background-color: #000;
  color: white;
  font-family: 'Roboto Condensed', sans-serif;
}

html {
  height: 100%;
}

body {
  height: calc(100% - 80px);
}

#app {
  margin: 40px;
  height: 100%;
}

.row {
  margin-bottom: 80px;
}

.row-bottom {
  position: fixed;
  bottom: 0;
  width: calc(100% - 80px);
}

.col-right, .col-left {
  position: relative;
}

.col-left {
  padding-left: 0;
}

/* Every Component with this class should be 400px in width */
.width-400 > * {
  width: 400px;
}

.col-right > * {
  position: absolute;
  right: 0;
}

/* The first Component should be placed at the top */
.col-right > *:first-child, .col-left > *:first-child {
  top: 0;
}

/* The last Component should be placed at the bottom */
.col-right > *:last-child, .col-left > *:last-child {
  bottom: 0;
}

H3 {
  font-size: 3rem;
}

h1 {
  font-size: 4.5rem;
}

</style>
