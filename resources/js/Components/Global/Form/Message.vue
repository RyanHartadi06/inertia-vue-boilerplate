<template>
  <div class="text-danger" role="alert">
    <span v-if="typeof errors == 'string'">{{ errors }}</span>
    <span v-else>
      <span v-for="(item, index) in errors" :key="index">
        {{ item }}
      </span>
    </span>
  </div>
</template>

<script>
export default {
  props: {
    errors: [Array, String],
  },
};
</script>