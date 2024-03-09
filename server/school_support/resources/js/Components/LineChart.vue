<script setup>
import { defineProps, computed, onMounted } from 'vue';
import { LineChart } from 'vue-chart-3';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

const props = defineProps({
  growths: Array,
});

const lineData = computed(() => {
  if (!props.growths || props.growths.length === 0) {
    return {
      labels: [],
      datasets: []
    };
  }

  const dateFormatter = new Intl.DateTimeFormat('ja-JP', {
    year: 'numeric',
    month: '2-digit',
  });

  return {
    labels: props.growths.map(item => dateFormatter.format(new Date(item.measurement_month))),
    datasets: [
      {
        label: '身長',
        data: props.growths.map(item => item.height),
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
        tension: 0.1,
      },
      {
        label: '体重',
        data: props.growths.map(item => item.weight),
        fill: false,
        borderColor: 'rgb(255, 99, 132)',
        tension: 0.1,
      },
    ]
  };
});
</script>

<template>
  <div>
    <LineChart :chartData="lineData" />
  </div>
</template>
