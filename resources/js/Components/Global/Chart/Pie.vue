<script>
import { Pie } from "vue-chartjs";

export default {
  extends: Pie,
  props: {
    datacollection: [Array, Object],
    options: [Array, Object],
  },
  data: () => ({
    htmlLegend: null,
  }),
  watch: {
    datacollection(data) {
      this.renderChart(data, this.options);
    },
  },
  mounted() {
    this.renderChart(this.datacollection, this.options);
    this.htmlLegend = this.generateLegend();
    this.$emit("legend", this.htmlLegend);
  },
};
</script>