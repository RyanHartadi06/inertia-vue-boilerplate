<template>
  <button
    class="
      btn
      d-flex
      align-items-center
      justify-content-center
      btn-primary
      waves-effect waves-light
    "
    :type="type"
    :class="classes"
    :disabled="loading"
    @click="action()"
  >
    <i
      class="bx bx-loader bx-spin font-size-16 align-middle"
      :class="{ 'me-2': label }"
      v-if="loading"
    ></i>
    <i
      :class="[icon, { 'me-2': label }]"
      v-else-if="icon"
      class="font-size-16 align-middle"
    ></i>
    {{ label }}
  </button>
</template>
<script>
export default {
  props: {
    label: String,
    type: {
      type: String,
      default: "submit",
    },
    classes: {
      type: String,
      default: "",
    },
    loading: {
      type: Boolean,
      default: false,
    },
    icon: {
      type: String,
      default: "",
    },
  },
  methods: {
    action() {
      this.$emit("click");
    },
  },
};
</script>
