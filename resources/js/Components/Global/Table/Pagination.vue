<template>
  <div class="d-flex justify-content-between mt-3">
    <div v-if="!!total">
      {{ `Menampilkan ${from} - ${to} Dari ${total} Data` }}
    </div>
    <ul class="pagination ms-auto">
      <li
        class="paginate_button page-item"
        v-for="(link, index) in links"
        :key="index"
        :class="link.active ? 'active' : ''"
      >
        <span
          v-if="checkPrev(link.label)"
          tabindex="0"
          :data-dt-idx="index"
          class="page-link cursor-pointer previous"
          @click="visit(link.url)"
        >
          <span aria-hidden="true">&laquo;</span>
          <span class="sr-only"> Previous</span></span
        >
        <span
          v-else-if="checkNext(link.label)"
          tabindex="0"
          :data-dt-idx="index"
          class="page-link cursor-pointer next"
          @click="visit(link.url)"
        >
          <span aria-hidden="true">&raquo;</span>
          <span class="sr-only">Next</span></span
        >
        <span
          v-else
          class="page-link cursor-pointer"
          @click="visit(link.url)"
          >{{ link.label }}</span
        >
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    links: {
      type: Array,
      default: () => [],
    },
    query: {
      type: Object,
      default: () => {},
    },
    perPageOptions: {
      type: Array,
      default: () => [10, 20, 50],
    },
    from: {
      type: Number,
      default: () => 0,
    },
    to: {
      type: Number,
      default: () => 0,
    },
    total: {
      type: Number,
      default: () => 0,
    },
  },
  methods: {
    checkPrev(label) {
      try {
        return label.includes("Previous") || label.includes("Sebelumnya");
      } catch (e) {
        return false;
      }
    },
    checkNext(label) {
      try {
        return label.includes("Next") || label.includes("Berikutnya");
      } catch (e) {
        return false;
      }
    },
    visit(route) {
      if (route) {
        this.$inertia.visit(route, {
          preserveScroll: true,
          preserveState: true,
        });
      }
    },
  },
};
</script>
