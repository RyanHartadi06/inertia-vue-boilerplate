<template>
  <div></div>
</template>

<script>
import alertify from "alertifyjs";

export default {
  watch: {
    "$page.props.flash": {
      handler(next) {
        this.showFlash(next);
      },
      deep: true,
    },
    "$page.props.errors": {
      handler(next) {
        if (Object.keys(this.$page.props.errors).length > 0) {
          alertify.error(
            `${this.validationMessage} Terdapat ${
              Object.keys(this.$page.props.errors).length
            } error pada form`
          );
          this.clearFlash();
        }
      },
      deep: true,
    },
  },
  computed: {
    validationMessage() {
      if (Object.keys(this.$page.props.errors).length > 0) {
        const key = Object.keys(this.$page.props.errors)[0];
        return this.$page.props.errors[key];
      }
      return null;
    },
  },
  methods: {
    showFlash(flash) {
      if (flash.success) {
        alertify.success(flash.success);
        this.clearFlash();
      }

      if (flash.error) {
        alertify.error(flash.error);
        this.clearFlash();
      }
    },
    clearFlash() {
      setTimeout(() => {
        this.$page.props.flash = {};
      }, 500);
    },
  },
  created() {
    this.showFlash(this.$page.props.flash);
  },
};
</script>

<style>
.ajs-message {
  color: white;
}
</style>