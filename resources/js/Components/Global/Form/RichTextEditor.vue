<template>
  <div>
    <label class="form-label"
      >{{ label }} <small v-if="required" class="text-danger">*</small></label
    >
    <div class="form-group">
      <vue-editor
        v-if="mode === modes[0]"
        class="bg-white w-full border rounded"
        :value="value"
        v-bind="$attrs"
        :placeholder="placeholder"
        @input="$emit('input', $event)"
      ></vue-editor>
      <div v-else-if="mode === modes[1]" class="w-full">
        <div class="ql-container ql-snow">
          <div class="ql-editor">
            <span v-html="value"></span>
          </div>
        </div>
      </div>
    </div>
    <small class="text-muted">{{ helpText }}</small>
    <form-message :errors="errors" />
  </div>
</template>

<script>
import { VueEditor } from "vue2-editor";
import FormMessage from "@/Components/Global/Form/Message.vue";

const MODES = ["edit", "show"];

export default {
  components: {
    VueEditor,
    FormMessage,
  },
  props: {
    label: String,
    placeholder: String,
    value: String,
    mode: {
      type: String,
      validator(val) {
        return MODES.includes(val);
      },
      default: MODES[0],
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
      modes: MODES,
    };
  },
};
</script>

<style>
.ql-container {
  height: unset !important;
  font-family: Montserrat !important;
}

.ql-toolbar.ql-snow {
  border-radius: 0.375rem 0.375rem 0 0;
  border-top: 0 !important;
  border-left: 0 !important;
  border-right: 0 !important;
  border-color: #d2d6dc;
}
.ql-container.ql-snow:not(.read-only) {
  border-radius: 0 0 0.375rem 0.375rem;
  border-color: #d2d6dc;
}

.ql-snow .ql-tooltip {
  position: unset !important;
}

.ql-container {
  border: 0 !important;
}

.ql-editor {
  color: initial !important;
}
</style>

<style scoped>
@import url("https://cdn.quilljs.com/1.3.6/quill.snow.css");
.ql-editor {
  min-height: unset;
  padding: 0 !important;
}
</style>
