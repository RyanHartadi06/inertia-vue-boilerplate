<template>
  <th class="px-2 py-2">
    <div
      class="d-flex align-items-center cursor-pointer h-8"
      :class="
        alignCenter ? 'justify-content-center' : 'justify-content-between'
      "
      @click="$emit('sort', sortingKey, queryOrder == 'desc' ? 'asc' : 'desc')"
    >
      {{ label }}
      <div v-if="enableSorting" class="ms-2 d-flex flex-column">
        <i
          class="bx bx-chevron-up"
          style="font-size: 18px"
          :class="
            querySort == sortingKey && queryOrder == 'desc'
              ? 'text-primary'
              : 'text-muted'
          "
        ></i>
        <i
          class="bx bx-chevron-down"
          style="font-size: 18px"
          :class="
            querySort == sortingKey && queryOrder == 'asc'
              ? 'text-primary'
              : 'text-muted'
          "
        ></i>
      </div>
    </div>
  </th>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      default: null,
    },
    enableSorting: {
      type: Boolean,
      default: false,
    },
    sortingKey: {
      type: String,
      default: null,
    },
    querySort: {
      type: String,
      default: null,
    },
    queryOrder: {
      type: String,
      default: "desc",
    },
    alignCenter: {
      type: Boolean,
      default: false,
    },
  },
};
</script>