<template>
  <div class="dropdown">
    <button
      type="button"
      class="btn dropdown-toggle w-100"
      :class="filtered ? 'btn-primary' : 'border'"
      data-bs-toggle="dropdown"
      aria-expanded="false"
    >
      <i class="bx bx-filter-alt"></i>
      Filter
    </button>
    <div class="dropdown-menu p-1 w-64" id="dropdown-menu-filter">
      <small class="d-flex justify-content-between text-muted w-100 mt-1">
        Filters
        <span class="cursor-pointer" v-if="filtered" @click="clear()"
          >(clear)</span
        >
      </small>
      <template v-for="(filter, key) in filtersAndValues">
        <dropdown-filter
          v-if="filter.componentName === 'dropdown-filter'"
          class="mt-2"
          :value="filter.value"
          :defaultLabel="filter.label"
          :key="key"
          :options="filter.options"
          :paramName="filter.paramName"
          @filter-changed="setFilter"
        ></dropdown-filter>
        <dropdown-filter-date
          v-if="filter.componentName === 'dropdown-filter-date'"
          class="mt-2"
          :value="filter.value"
          :key="key"
          :paramName="filter.paramName"
          @filter-changed="setFilter"
        />
      </template>
    </div>
  </div>
</template>

<script>
import DropdownFilter from "@/Components/Global/Table/Filter/DropdownFilter.vue";
import DropdownFilterDate from "@/Components/Global/Table/Filter/DropdownFilterDate.vue";

export default {
  components: {
    DropdownFilter,
    DropdownFilterDate,
  },
  props: {
    filters: {
      type: Array,
      default: [],
    },
    modelValue: {
      type: Object,
      default: {},
    },
  },
  data() {
    return {
      localValue: this.modelValue,
    };
  },
  methods: {
    setFilter(filter) {
      delete this.localValue[filter.key];
      if (filter.value != null) {
        this.localValue[filter.key] = filter.value;
      }
      this.$emit("update:modelValue", this.localValue);
    },
    clear() {
      for (let i in this.filters) {
        if (this.get(this.localValue, this.filters[i].paramName) != null) {
          delete this.localValue[this.filters[i].paramName];
        }
      }
    },
    get(object, key) {
      return object[key] ?? null;
    },
  },
  computed: {
    filtered() {
      for (let i in this.filters) {
        if (this.get(this.localValue, this.filters[i].paramName) != null) {
          return true;
        }
      }
      return false;
    },
    filtersAndValues() {
      return this.filters.map((filter) => {
        filter.value = this.get(this.localValue, filter.paramName);
        return filter;
      });
    },
  },
};
</script>