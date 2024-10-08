<template>
  <div>
    <label class="cursor-pointer"
      >{{ label }} <small v-if="required" class="text-danger">*</small></label
    >
    <div class="form-check form-switch" dir="ltr">
      <input
        type="checkbox"
        class="form-check-input"
        :id="id"
        :checked="modelValue"
        :value="trueValue"
        v-model="selected"
      />
      <label class="form-check-label ms-2" :for="id">{{ placeholder }}</label>
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
    id: [String, Number],
    label: {
      type: String,
      default: "",
    },
    placeholder: {
      type: String,
      default: "",
    },
    modelValue: [String, Boolean],
    trueValue: {
      type: [String, Boolean],
      default: true,
    },
    required: {
      type: Boolean,
      default: false,
    },
    helpText: {
      type: String,
      default: "",
    },
    errors: {
      type: [Array, String],
      default: () => [],
    },
  },
  data() {
    return {
      selected: this.modelValue == this.trueValue,
    };
  },
  watch: {
    selected: function (data) {
      this.$emit("input", this.selected);
    },
  },
};
</script>

