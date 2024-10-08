<template>
  <div class="mb-2">
    <label class="form-label"
      >{{ label }} <small v-if="required" class="text-danger">*</small></label
    >
    <div
      class="form-check text-muted ms-2"
      v-for="(item, index) in options"
      :key="index"
    >
      <label>
        <input
          class="form-check-input"
          type="radio"
          :name="name"
          :value="item.value || item.id"
          v-model="selected"
          @input="$emit('update:modelValue', $event.target.value)"
        />
        {{ item.label || item.name }}
      </label>
    </div>
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
    name: {
      type: String,
      default: "radio",
    },
    placeholder: String,
    modelValue: [String, Number, Boolean],
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
    modelValue(next) {
      this.selected = next;
    },
  },
};
</script>

