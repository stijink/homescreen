<template>
  <div id="error" v-bind:class="{ 'sr-only': hasNoError }">
      <strong>{{ message }}</strong> - {{ description }}
  </div>
</template>

<script>
export default {
  data () {
    return {
        message: null,
        description: null,
    }
  },
  computed: {
    hasNoError: function() {
        return this.message === null;
    }
  },
  mounted() {

      ErrorEvent.$on('error', function (response) {
          this.message = response.message;
          this.description = response.description;
      }.bind(this));

      ErrorEvent.$on('reset', function (response) {
          this.message = null;
          this.description = null;
      }.bind(this));
  }
}
</script>

<style scoped>

  #error {
    background-color: #bd4147;
    color: #fff;

    position: absolute;
    left: 0;
    bottom: 0;

    height: 40px;
    width: 100%;

    padding: 6px 0px 5px 15px;
  }

</style>
