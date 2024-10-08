<script>
import { Bar } from "vue-chartjs";

export default {
    extends: Bar,
    props: {
        datacollection: [Array, Object],
        options: [Array, Object],
    },
    mounted() {
        this.renderChart(this.datacollection, this.options);
    },
};
</script>