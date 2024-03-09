<script setup>
import { Chart, registerables } from "chart.js";
import { LineChart } from "vue-chart-3";
import { reactive, computed } from "vue"

// const props = defineProps({
//   "data" : Object
// })

// const labels = computed(() => props.data.labels)
// const totals = computed(() => props.data.totals)

Chart.register(...registerables);

// const lineData = reactive({
const lineData = reactive({
    // labels: labels,
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
    datasets: [
        {
            label: '身長',
            // data: totals,
            data: [125, 126, 128, 130, 131, 131, 132],
            fill: false,
            borderColor: "rgb(75, 192, 192)",
            tension: 0.1,
        }
    ]
})
</script>

<template>
  <div>
    <LineChart :chartData="lineData" />
  </div>
</template>
