<template>
  <div :class="parentClass">
    <label class="cursor-pointer"
      >{{ label }} <small v-if="required" class="text-danger">*</small></label
    >
    <div class="form-check" v-if="!options.length">
      <input
        id="singleCheckbox"
        class="form-check-input"
        type="checkbox"
        name="checkbox"
        :value="value"
        v-model="selected"
      />
      <label class="cursor-pointer" for="singleCheckbox">{{
        placeholder
      }}</label>
    </div>
    <div class="form-check" v-for="(item, index) in options" :key="index">
      <input
        :id="item.value || item.id"
        class="form-check-input"
        type="checkbox"
        name="checkbox"
        :value="item.value || item.id"
        v-model="selected"
      />
      <label class="cursor-pointer" :for="item.value || item.id">{{
        item.label || item.name
      }}</label>
    </div>
    <div>
      <small class="text-muted">{{ helpText }}</small>
    </div>
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
    parentClass: String,
    placeholder: String,
    modelValue: [String, Number, Boolean, Array],
    required: {
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
  },
  data() {
    return {
      selected: this.modelValue,
    };
  },
  watch: {
    selected: function (data) {
      this.$emit("update:modelValue", val);
    },
  },
};
</script>

