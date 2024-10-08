<template>
  <div :class="[{ 'has-danger': errors.length }, classes]">
    <div class="d-flex justify-content-between align-items-center">
      <label class="form-label" v-if="label"
        >{{ label }} <small v-if="required" class="text-danger">*</small></label
      >
      <small class="text-muted" v-if="subLabel">{{ subLabel }}</small>
    </div>

    <div class="input-group">
      <input
        :type="type"
        class="form-control"
        :placeholder="placeholder"
        v-model="localValue"
        v-bind="$attrs"
        :disabled="disabled"
        :required="required"
        :id="id"
        @input="input"
      />
      <div class="input-group-text" v-if="append">{{ append }}</div>
    </div>

    <small v-if="helpText">{{ helpText }}</small>

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
    id: {
      type: String,
      default: "id-text-field1",
    },
    label: String,
    subLabel: {
      type: String,
      default: "",
    },
    placeholder: String,
    type: String,
    modelValue: [String, Number],
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
      default: "bx bxs-check-circle",
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
    small: {
      type: Boolean,
      default: true,
    },
    prefix: {
      type: String,
      default: "Rp",
    },
    append: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      localValue: this.modelValue,
    };
  },
  computed: {
    localType() {
      if (this.type === "currency") {
        return "text";
      }
      return this.type;
    },
    options() {
      if (this.type === "currency") {
        return {
          numeral: true,
          numeralThousandsGroupStyle: "thousand",
          numeralDecimalMark: ".",
          delimiter: ".",
        };
      }
    },
  },
  watch: {
    modelValue(next) {
      this.localValue = next;
    },
  },
  methods: {
    input(e) {
      let value = e.target.value;

      this.localValue = value;
      if (this.type === "phone") {
        value = this.restrictToNumbers(value);
      }
      if (this.type === "currency") {
        value = this.restrictToNumbers(value);
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }
      this.$emit("update:modelValue", value);
    },
    restrictToNumbers(val) {
      return val.replace(/[^0-9]/g, "");
    },
  },
};
</script>
