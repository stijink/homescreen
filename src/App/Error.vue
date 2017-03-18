<template>
  <div id="error-dialog">
    <div class="modal fade" v-bind:class="{ show:hasError }">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-danger">
              <i class="fa fa-exclamation-triangle"></i>
              &nbsp; {{ message }}
            </h5>
          </div>
          <div class="modal-body">
            <p>{{ description }} </p>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade" v-bind:class="{ show:hasError }"></div>
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

<style>

  .modal {
    color: black;
    top: 25%;
  }

  .modal.show {
    display: block;
  }

  .modal-backdrop.show {
    opacity: .7;
  }

</style>
