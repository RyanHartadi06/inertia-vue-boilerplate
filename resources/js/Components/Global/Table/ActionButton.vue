<template>
  <div class="dropdown me-2">
    <button
      type="button"
      class="btn dropdown-toggle border"
      data-bs-toggle="dropdown"
      aria-haspopup="true"
      aria-expanded="false"
    >
      Action
    </button>
    <div class="dropdown-menu p-1" v-on:click.stop>
      <div v-for="(item, index) in options" :key="index">
        <div
          class="dropdown-item cursor-pointer"
          @click="$emit('selectedAction', item.key)"
        >
          {{ item.name }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    options: {
      type: Array,
      default: [],
    },
  },
};
</script>