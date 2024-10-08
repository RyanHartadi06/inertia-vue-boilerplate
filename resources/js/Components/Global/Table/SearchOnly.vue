<template>
  <div class="col-md-12">
    <text-field
      type="text"
      id="search"
      v-model="search"
      label="Cari Nama / Desa"
      placeholder="Cari Nama / Desa..."
    />
  </div>
</template>

<script>
import TextField from "@/Components/Global/Form/TextField.vue";

export default {
  components: {
    TextField,
  },
  props: {
    query: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      search: this.query.search || null,
    };
  },
  watch: {
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
    changeFilterSearch(searchFilter) {
      this.$emit("changeSearch", searchFilter);
    },
  },
};
</script>
