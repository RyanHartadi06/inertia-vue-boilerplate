<template>
  <div class="mb-2" :class="{ 'has-danger': errors.length }">
    <label class="form-label"
      >{{ label }} <small v-if="required" class="text-danger">*</small></label
    >
    <multi-select
      v-model="selected"
      :options="options"
      :track-by="optionsType === 'object' ? searchBy : null"
      :label="optionsType === 'object' ? optionLabel : null"
      :multiple="multiple"
      @search-change="onSearchChange"
      selectLabel
      selectedLabel
      deselectLabel
      :allow-empty="allowEmpty"
      :close-on-select="closeOnSelect === null ? !multiple : closeOnSelect"
      :clear-on-select="false"
      :searchable="searchable"
      :taggable="taggable"
      @tag="addTag"
      :tag-placeholder="taggable ? 'Tambah tag' : ''"
      :placeholder="placeholder"
    ></multi-select>
    <small class="text-muted">{{ helpText }}</small>
    <form-message :errors="errors" />
  </div>
</template>

<script>
import FormMessage from "@/Components/Global/Form/Message.vue";
import MultiSelect from "vue-multiselect";

export default {
  components: {
    FormMessage,
    MultiSelect,
  },
  props: {
    label: String,
    placeholder: {
      type: String,
      default: "Select",
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
    value: [String, Number, Boolean, Object, Array],
    searchBy: {
      type: String,
      default: "value",
    },
    multiple: {
      type: Boolean,
      default: false,
    },
    remote: Boolean,
    optionLabel: {
      type: String,
      default: "label",
    },
    options: {
      type: Array,
      default: () => [],
    },
    selectorKey: {
      type: String,
      default: "*",
    },
    taggable: {
      type: Boolean,
      default: false,
    },
    searchable: {
      type: Boolean,
      default: false,
    },
    closeOnSelect: {
      type: Boolean,
      default: null,
    },
    allowEmpty: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {
      optionsType: typeof this.options[0],
    };
  },
  computed: {
    selected: {
      get() {
        if (!this.value || this.selectorKey === "*") return this.value;
        else {
          if (this.value && Array.isArray(this.value)) {
            // support multiple
            return this.value.map((item) => {
              return this.options.find(
                (option) => option[this.selectorKey] === item
              );
            });
          } else {
            // not support multiple
            return this.options.find(
              (option) => option[this.selectorKey] === this.value
            );
          }
        }
      },
      set(val) {
        let data;
        if (!val || this.selectorKey === "*") data = val;
        else {
          if (val && Array.isArray(val)) {
            // support multiple
            data = val.map((item) => {
              return item[this.selectorKey];
            });
          } else {
            // not support multiple
            data = val[this.selectorKey];
          }
        }
        this.$emit("input", data);
      },
    },
  },
  watch: {
    options: {
      immediate: true,
      handler(next) {
        this.optionsType = typeof this.options[0];
      },
    },
  },
  methods: {
    onSearchChange(val) {
      if (this.remote) {
        this.$emit("searchChange", val);
      }
    },
    addTag(newTag) {
      if (!this.taggable) return;
      const newData = {};
      newData[this.optionLabel] = newTag;
      this.$emit("input", [...(this.value || []), newData]);
    },
  },
};
</script>

<style>
.multiselect__tags {
  padding: 0px 40px 0px 8px !important;
}

.multiselect__placeholder {
  margin-top: 5px !important;
  margin-bottom: 8px !important;
}

.multiselect__input,
.multiselect__single {
  margin-top: 8px !important;
}
</style>