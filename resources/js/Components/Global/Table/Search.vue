<template>
  <div class="row">
    <div class="col-sm-6 pb-1">
      <div class="d-flex">
        <select
          class="form-select w-25"
          tabindex="-1"
          aria-hidden="true"
          v-model="perPage"
        >
          <option
            v-for="(item, index) in perPageOptions"
            :key="index"
            :value="item"
          >
            {{ item }}
          </option>
        </select>
        <div class="w-75 ps-2 d-flex align-items-center">
          {{ perPage }}
          <span class="ms-1">records per page</span>
        </div>
      </div>
    </div>
    <div class="col-sm-6 pb-1">
      <input
        v-model="search"
        class="form-control"
        :placeholder="placeholder"
        v-if="showSearch"
      />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    placeholder: {
      type: String,
      default: "Search...",
    },
    query: {
      type: Object,
      default: () => {},
    },
    perPageOptions: {
      type: Array,
      default: () => [10, 20, 50],
    },
    showSearch: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {
      perPage: this.query.per_page,
      search: null,
    };
  },
  watch: {
    perPage: {
      handler(val) {
        this.changeFilterPerPage(val);
      },
      deep: true,
    },
    search: {
      handler(val) {
        this.changeFilterSearch(val);
      },
      deep: true,
    },
  },
  methods: {
    visit(route) {
      if (route) {
        this.$inertia.visit(route, {
          preserveScroll: true,
          preserveState: true,
        });
      }
    },
    /**
     * change filer per page
     * @param {Number} perPageFilter - value filter per page
     */
    changeFilterPerPage(perPageFilter) {
      this.$emit("changePerPage", perPageFilter);
    },
    changeFilterSearch(searchFilter) {
      this.$emit("changeSearch", searchFilter);
    },
  },
};
</script>