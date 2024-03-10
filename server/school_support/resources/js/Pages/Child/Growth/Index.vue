<script setup>
import AuthenticatedChildLayout from '@/Layouts/AuthenticatedChildLayout.vue';
import { Head } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import LineChart from '@/Components/LineChart.vue';

const props = defineProps({
    growths: Object,
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

                                    <LineChart :growths="growths" />

                                    <div style="max-width: 1000px; overflow-x: auto;" class="mt-6">
                                        <div class="w-full mt-12 pr-12 border-t-2 border-zinc-300">
                                        </div>
                                        <div v-for="growth in growths" class="w-full pr-12 py-3 flex justify-between border-b-2 border-zinc-300">
                                            <p class="text-md mr-3">
                                                計測日: {{ dayjs(growth.measurement_month).format('YYYY/MM/DD') }}
                                            </p>
                                            <p class="text-md mr-3">
                                                身長: {{ growth.height }}cm
                                            </p>
                                            <p class="text-md mr-3">
                                                体重: {{ growth.weight }}kg
                                            </p>
                                            <p class="text-md mr-3">
                                                胸囲: {{ growth.chest }}cm
                                            </p>
                                            <p class="text-md mr-3">
                                                腹囲: {{ growth.abdomen }}cm
                                            </p>
                                            <p class="text-md">
                                                頭囲: {{ growth.head }}cm
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
