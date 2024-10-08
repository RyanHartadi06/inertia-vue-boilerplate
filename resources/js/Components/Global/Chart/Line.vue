<script>
import { Line } from "vue-chartjs";

export default {
  extends: Line,
  props: {
    datacollection: [Array, Object],
    options: [Array, Object],
  },
  mounted() {
    this.renderChart(this.datacollection, this.options);
  },
};
</script>