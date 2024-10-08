<template>
  <component :is="$listeners.submit ? 'form' : 'div'" @submit.prevent="submit">
    <slot></slot>

    <div :class="actionClass">
      <slot name="actions"></slot>
    </div>
  </component>
</template>

<script>
export default {
  props: {
    actionClass: String,
  },
  methods: {
    submit() {
      this.$emit("submit");
    },
  },
};
</script>
