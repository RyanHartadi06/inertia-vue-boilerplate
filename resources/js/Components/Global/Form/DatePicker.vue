<template>
  <div>
    <date-picker
      v-model="selected"
      :type="type"
      :range="range"
      class="w-100"
      id="m-datepicker"
      :placeholder="placeholder"
      :disabled="disabled"
    />
  </div>
</template>
<script>
const TYPES = ["date", "datetime", "year", "month", "time", "week"];

export default {
  props: {
    value: {
      type: [Array, String],
      default: null,
    },
    options: Array,
    placeholder: String,
    type: {
      type: String,
      validator(val) {
        return TYPES.includes(val);
      },
    },
    range: {
      type: Boolean,
      default: false,
    },
    format: {
      type: String,
      default: "DD-MM-YYYY",
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      types: TYPES,
      selected: this.value,
    };
  },
  watch: {
    selected: {
      immediate: true,
      handler(val) {
        this.emit(val);
      },
    },
    value: {
      immediate: true,
      handler(val) {
        if (!val) {
          this.selected = null;
        }
      },
    },
  },
  methods: {
    emit(value) {
      let val = value || null;
      let start =
        val && val[0] ? this.moment(val[0]).format("YYYY-MM-DD") : null;
      let end =
        val && val[1] ? this.moment(val[1]).format("YYYY-MM-DD") : null;

      if (this.range) {
        this.$emit("input", [start, end]);
      } else {
        this.$emit("input", start);
      }
    },
  },
  created() {
    setTimeout(() => {
      let el = document.querySelector("#m-datepicker");
      let formDate = el.children[0].children[0];
      formDate.classList.remove("mx-input");
      formDate.classList.add("form-control");
      formDate.classList.add("form-control-sm");
    }, 100);
  },
};
</script>
