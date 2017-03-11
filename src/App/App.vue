<template>
  <div id="app">

    <clock></clock>
    <calendar></calendar>
    <news></news>

    <weather></weather>
    <weather-forcast></weather-forcast>

    <petrol></petrol>
    <traffic></traffic>

    <error></error>

  </div>
</template>

<style>
body {
  background-color: #999;
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
  position: relative;
  height: 100%;
}

h1 {
    font-size: 3.5rem;
}

h3 {
    font-size: 2rem;
}

</style>
