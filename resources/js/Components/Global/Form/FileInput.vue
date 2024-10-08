<template>
  <div class="mb-2">
    <div class="d-flex justify-content-between align-items-center">
      <label class="form-label"
        >{{ label }} <small v-if="required" class="text-danger">*</small></label
      >
      <small class="text-muted" v-if="maxSize">max {{ maxSize }}</small>
    </div>
    <div
      class="rounded border text-center"
      :class="{
        'border-danger': errors.length,
      }"
    >
      <div
        v-if="!noPreview && !multiple && preview"
        v-bind:style="{
          backgroundImage: `url(${preview})`,
          backgroundRepeat: 'no-repeat',
          backgroundSize: 'contain',
          backgroundPosition: 'center',
          height: '100px',
        }"
      ></div>
      <i v-else :class="imageIcon" />
    </div>
    <input
      :id="id"
      ref="file"
      type="file"
      :accept="accept"
      @change="change"
      :class="{
        'form-control': errors.length,
      }"
      class="d-none"
      :multiple="multiple"
    />

    <slot
      :value="modelValue"
      :preview="preview"
      :browse="browse"
      :remove="remove"
    >
      <div v-if="!modelValue" class="py-2 d-flex justify-content-end">
        <button
          type="button"
          class="btn btn-sm btn-primary d-flex align-items-center me-2"
          @click="browse"
        >
          <i class="bx bx-file-find me-1"></i>
          Browse
        </button>
      </div>
      <div
        v-else
        class="d-flex py-2 justify-content-between align-items-center"
      >
        <div v-if="typeof modelValue === 'string'" class="d-flex pe-1">
          {{
            cutString(
              modelValue
                .split("/")
                .slice(
                  modelValue.split("/").length - 1,
                  modelValue.split("/").length
                )
                .join("/")
            )
          }}
        </div>
        <div v-else class="d-flex align-items-center pe-1">
          {{ cutString(modelValue.name) }}
          <small class="text-muted ps-2"
            >({{ filesize(modelValue.size) }})</small
          >
        </div>
        <button
          type="button"
          class="btn btn-sm btn-danger d-flex align-items-center me-2"
          @click="remove"
        >
          <i class="bx bx-trash-alt me-1"></i>
          Hapus
        </button>
      </div>
      <form-message :errors="errors" />
    </slot>
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
      default() {
        return `file-input-1`;
      },
    },
    modelValue: [File, String],
    label: String,
    required: {
      type: Boolean,
      default: false,
    },
    accept: {
      type: String,
      default: "*",
    },
    errors: {
      type: [Array, String],
      default: () => [],
    },
    helpText: String,
    required: {
      type: Boolean,
      default: false,
    },
    noPreview: {
      type: Boolean,
      default: false,
    },
    fluid: Boolean,
    multiple: Boolean,
    imageIcon: {
      type: String,
      default: " bx bxs-image-add display-3",
    },
    maxSize: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      preview: null,
    };
  },
  watch: {
    modelValue: {
      handler(value) {
        if (!value) {
          this.$refs.file.value = "";
        } else {
          this.readfile(value);
        }
      },
    },
  },
  computed: {
    showFileName() {
      return this.value && typeof this.value !== "string";
    },
  },
  mounted() {
    if (typeof this.modelValue === "string") {
      this.preview = this.modelValue;
    } else if (this.modelValue) {
      this.readfile(this.modelValue);
    }
  },
  methods: {
    filesize(size) {
      var i = Math.floor(Math.log(size) / Math.log(1024));
      return (
        (size / Math.pow(1024, i)).toFixed(2) * 1 +
        " " +
        ["B", "kB", "MB", "GB", "TB"][i]
      );
    },
    browse() {
      this.$refs.file.click();
    },
    clear() {
      this.$refs["file"].value = "";
    },
    change(e) {
      if (e.target.files && this.multiple) {
        const files = Array.from(e.target.files);
        this.$emit("update:modelValue", files, { clear: this.clear });
      } else {
        this.$emit("update:modelValue", e.target.files[0]);
        this.readfile(e.target.files[0]);
      }
    },
    readfile(file) {
      var reader = new FileReader();

      reader.onload = (val) => {
        if (val.target.result.includes("data:image"))
          this.preview = val.target.result;

        this.$emit("getPreview", val.target.result);
      };
      reader.readAsDataURL(file); // convert to base64 string
    },
    remove() {
      this.preview = "";
      this.$emit("update:modelValue", null);
    },
    cutString(val) {
      const start = val.length > 20 ? val.length - 20 : 0;
      const dot = val.length > 20 ? "..." : "";
      return dot + val.substring(start, val.length);
    },
  },
};
</script>
