<template>
  <div :class="[{ 'has-danger': errors.length }, classes]">
    <div class="d-flex justify-content-between align-items-center">
      <label class="form-label"
        >{{ label }} <small v-if="required" class="text-danger">*</small></label
      >
      <small class="text-muted" v-if="subLabel">{{ subLabel }}</small>
    </div>

    <div class="input-group input-group-sm" v-if="icon">
      <div class="input-group-prepend">
        <span class="input-group-text"><i :class="iconClass"></i></span>
      </div>
      <textarea
        :type="type"
        class="form-control"
        :placeholder="placeholder"
        @input="input"
        v-bind="$attrs"
        :required="required"
        :disabled="disabled"
        :rows="rows"
        :value="modelValue"
      ></textarea>
    </div>
    <textarea
      v-else
      :type="type"
      class="form-control"
      :placeholder="placeholder"
      @input="input"
      v-bind="$attrs"
      :required="required"
      :disabled="disabled"
      :rows="rows"
      :value="modelValue"
    ></textarea>
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
    subLabel: {
      type: String,
      default: "",
    },
    placeholder: String,
    type: String,
    disabled: {
      type: Boolean,
      default: false,
    },
    required: {
      type: Boolean,
      default: false,
    },
    icon: {
      type: Boolean,
      default: false,
    },
    iconClass: {
      type: String,
      default: " bx bxs-check-circle",
    },
    classes: {
      type: String,
      default: "mb-3",
    },
    helpText: {
      type: String,
      default: "",
    },
    errors: {
      type: [Array, String],
      default: () => [],
    },
    rows: {
      type: Number,
      default: 3,
    },
    modelValue: String,
  },
  methods: {
    input(e) {
      this.$emit("update:modelValue", e.target.value);
    },
  },
};
</script>


