<template>
  <div class="w-full">
    <VueDatePicker
      v-model="date"
      range
      auto-apply
      :enable-time-picker="false"
      placeholder="Select start date - end date"
    />
  </div>
</template>
<script>
export default {
  props: {
    value: {
      type: [Number, String, Boolean],
      default: null,
    },
    paramName: String,
  },
  data() {
    return {
      date: this.value,
      form: {
        start_date: null,
        end_date: null,
      },
    };
  },
  watch: {
    value: {
      handler: function (val) {
        // this.date = val;
      },
      immediate: true,
    },
    date: function (val) {
      this.form.start_date =
        val && val.length > 0 ? this.moment(val[0]).format("YYYY-MM-DD") : null;
      this.form.end_date =
        val && val.length > 0 ? this.moment(val[1]).format("YYYY-MM-DD") : null;

      this.$emit("filter-changed", {
        key: this.paramName,
        value: {
          0: this.form.start_date,
          1: this.form.end_date,
        },
      });
    },
  },
  mounted() {
    this.date = this.value;
  },
};
</script>
