<script setup>
import AuthenticatedChildLayout from '@/Layouts/AuthenticatedChildLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, nextTick } from 'vue';
import LineChart from '@/Components/LineChart.vue';

const props = defineProps({
    growths: Object,
});

const chartData = {
  labels: ['January', 'February', 'March', 'April'],
  datasets: [{
    label: 'Demo',
    data: [65, 59, 80, 81],
    fill: false,
    borderColor: 'rgb(75, 192, 192)',
    tension: 0.1
  }]
};

onMounted(async () => {
  await nextTick();
  const ctx = canvas.value.getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: props.chartData,
    options: props.chartOptions,
  });
});
</script>
<template>
    <Head title="成長記録" />

    <AuthenticatedChildLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                成長記録
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font">
                            <div class="px-5 mx-auto">
                                <div class="w-full mx-auto overflow-auto">
                                    <div class="text-center font-semibold mb-10">
                                        <h2 class="text-lg">成長記録</h2>
                                    </div>
                                    <template>
                                        <LineChart :chart-data="chartData" :chart-options="chartOptions" />
                                    </template>
                                    <div class="text-left mt-12 flex items-center">
                                        <div class="text-sm">
                                            期間　
                                        </div>
                                        <form action="" class="mb-0" method="GET" id="sortForm">
                                            <select name="sort" id="sort" class="pl-2 pr-10 border-solid border-2 border-zinc-500 rounded-md text-sm">
                                                <option value="all">すべて</option>

                                                    <option value=""></option>

                                            </select>
                                        </form>
                                    </div>
                                    <div style="max-height: 500px; overflow-y: auto;" class="mt-6">
                                        <div class="mt-12 border-t-2 border-zinc-300">
                                        </div>

                                            <div class="w-full px-5 py-3 flex justify-between border-b-2 border-zinc-300">
                                                <p class="text-md">

                                                </p>
                                                <p class="text-md">

                                                </p>
                                            </div>

                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedChildLayout>
</template>
