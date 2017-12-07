<template>
  <div class="snow"></div>
</template>

<style scoped>

  .snow {
    background: none;
    font-family: Androgyne;
    background-image: url('http://www.wearewebstars.dk/codepen/img/s1.png'), url('http://www.wearewebstars.dk/codepen/img/s2.png'), url('http://www.wearewebstars.dk/codepen/img/s3.png');
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
    z-index:1;
    animation: snow 10s linear infinite;
    filter: brightness(65%);
  }
  @keyframes snow {
    0% {background-position: 0px 0px, 0px 0px, 0px 0px;}
    50% {background-position: 500px 500px, 100px 200px, -100px 150px;}
    100% {background-position: 500px 1000px, 200px 400px, -100px 300px;}
  }

</style>
