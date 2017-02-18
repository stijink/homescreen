<template>
  <div id="app">
    <clock></clock>
    <weather></weather>
    <persons></persons>
  </div>
</template>

<script>
export default {
  data () {
    return {
    }
  }
}
</script>

<style lang="scss">
body {
  background-color: #999;
  color: white;
  font-family: 'Roboto Condensed', sans-serif;
}

#app {
  margin: 40px;
  position: relative;

  h1 {
    font-size: 3.5rem;
  }

  h3 {
    font-size: 2rem;
  }
}

</style>
