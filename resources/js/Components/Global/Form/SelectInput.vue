<template>
  <div class="mb-3" :class="{ 'has-danger': errors.length }">
    <label class="form-label"
      >{{ label }} <small v-if="required" class="text-danger">*</small></label
    >
    <select
      :id="id"
      class="form-select"
      @input="input"
      :value="this.localValue"
      :required="required"
      :disabled="disabled"
    >
      <option value="">- {{ placeholder }} -</option>
      <option
        v-for="(item, index) in options"
        :key="index"
        :value="item.value || item.id"
      >
        {{ item.label || item.name }}
      </option>
    </select>
    <small class="text-muted">{{ helpText }}</small>
    <form-message :errors="errors" />
  </div>
</template>

<script>
import FormMessage from "@/Components/Global/Form/Message.vue";

export default {
  components: {
    FormMessage,
  },
  props: {
    label: String,
    id: String,
    placeholder: String,
    required: {
      type: Boolean,
      default: false,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    helpText: {
      type: String,
      default: "",
    },
    options: {
      type: Array,
      default: () => [],
    },
    errors: {
      type: [Array, String],
      default: () => [],
    },
    currentVal: [String, Number],
    modelValue: [String, Number],
  },
  data() {
    return {
      localValue: this.currentVal ? this.currentVal : this.modelValue,
    };
  },
  computed: {
    allOptions() {
      return this.options
        ? this.options.map((item) => {
            return {
              value: item[this.selectorValue] || item["id"],
              label: item[this.selectorLabel] || item["name"],
            };
          })
        : null;
    },
  },
  watch: {
    currentVal(data) {
      this.localValue = data;
    },
  },
  methods: {
    input(e) {
      let value = e.target.value;
      this.localValue = value;
      this.$emit("update:modelValue", value);
    },
  },
};
</script>


