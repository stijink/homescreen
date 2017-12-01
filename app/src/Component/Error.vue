<template>
  <v-snackbar color="error" bottom timeout="100000" v-model="hasError" multi-line>
      {{ description }}
    </v-snackbar>
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
    hasError: function() {
        return this.message !== null;
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
