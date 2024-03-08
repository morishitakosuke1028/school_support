<script setup>
import { onMounted, ref, nextTick } from 'vue';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

const props = defineProps({
  chartData: Object,
  chartOptions: Object,
});

const canvas = ref(null);

onMounted(() => {
  nextTick(() => {
    if (canvas.value) {
      const ctx = canvas.value.getContext('2d');
      new Chart(ctx, {
        type: 'line',
        data: props.chartData,
        options: props.chartOptions,
      });
    }
  });
});
</script>

<template>
    <canvas :ref="canvasRef"></canvas>
</template>
