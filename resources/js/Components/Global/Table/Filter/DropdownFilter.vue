<template>
  <div class="d-flex w-100">
    <select ref="input" v-model="selected" class="form-select">
      <option :value="null">Select {{ defaultLabel }}</option>
      <option v-for="(option, key) in options" :key="key" :value="option.name">
        {{ option.value }}
      </option>
    </select>
  </div>
</template>
<script>
export default {
  props: {
    value: {
      type: [Number, String, Boolean],
      default: null,
    },
    paramName: String,
    options: Array,
    defaultLabel: String,
  },
  data() {
    return {
      selected: this.value,
    };
  },
  watch: {
    selected: function (val) {
      this.$emit("filter-changed", {
        key: this.paramName,
        value: val,
      });
    },
    value: function (val) {
      this.selected = val;
    },
  },
  methods: {
    focus() {
      this.$refs.input.focus();
    },
    select() {
      this.$refs.input.select();
    },
  },
};
</script>
