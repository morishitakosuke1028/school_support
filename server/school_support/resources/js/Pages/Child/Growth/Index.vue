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

                                    <div style="max-height: 500px; overflow-y: auto;" class="mt-6">
                                        <div class="mt-12 border-t-2 border-zinc-300">
                                        </div>
                                        <div v-for="growth in growths" class="w-full px-5 py-3 flex justify-between border-b-2 border-zinc-300">
                                            <p class="text-md">
                                                計測日:
                                            </p>
                                            <p class="text-md">
                                                {{ dayjs(growth.measurement_month).format('YYYY/MM/DD') }}
                                            </p>
                                            <p class="text-md">
                                                身長:
                                            </p>
                                            <p class="text-md">
                                                {{ growth.height }}
                                            </p>
                                            <p class="text-md">
                                                体重:
                                            </p>
                                            <p class="text-md">
                                                {{ growth.weight }}
                                            </p>
                                            <p class="text-md">
                                                胸囲:
                                            </p>
                                            <p class="text-md">
                                                {{ growth.chest }}
                                            </p>
                                            <p class="text-md">
                                                腹囲:
                                            </p>
                                            <p class="text-md">
                                                {{ growth.abdomen }}
                                            </p>
                                            <p class="text-md">
                                                頭囲:
                                            </p>
                                            <p class="text-md">
                                                {{ growth.head }}
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
