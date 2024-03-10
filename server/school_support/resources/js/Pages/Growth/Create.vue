<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { reactive } from 'vue'
import dayjs from 'dayjs';

defineProps({
    errors: Object
})

const { child, growths } = usePage().props;

const form = reactive({
    child_id: child.id,
    height: null,
    weight: null,
    chest: null,
    abdomen: null,
    head: null,
    measurement_month: null,
})

const storeGrowth = () => {
    router.post('/growths', form)
}
</script>

<template>
    <Head title="成長記録登録" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ child.name }}さんの成長記録登録
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="storeGrowth">
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="height" class="leading-7 text-sm text-gray-600">身長</label>
                                                    <input type="number" id="height" name="height" step="any" v-model="form.height" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <div v-if="errors.height" class="mt-3 text-red-500 text-xs">{{ errors.height }}</div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="weight" class="leading-7 text-sm text-gray-600">体重</label>
                                                    <input type="number" id="weight" name="weight" step="any" v-model="form.weight" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <div v-if="errors.weight" class="mt-3 text-red-500 text-xs">{{ errors.weight }}</div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="chest" class="leading-7 text-sm text-gray-600">胸囲</label>
                                                    <input type="number" id="chest" name="chest" step="any" v-model="form.chest" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <div v-if="errors.chest" class="mt-3 text-red-500 text-xs">{{ errors.chest }}</div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="abdomen" class="leading-7 text-sm text-gray-600">腹囲</label>
                                                    <input type="number" id="abdomen" name="abdomen" step="any" v-model="form.abdomen" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <div v-if="errors.abdomen" class="mt-3 text-red-500 text-xs">{{ errors.abdomen }}</div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="head" class="leading-7 text-sm text-gray-600">頭囲</label>
                                                    <input type="number" id="head" name="head" step="any" v-model="form.head" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <div v-if="errors.head" class="mt-3 text-red-500 text-xs">{{ errors.head }}</div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="measurement_month" class="leading-7 text-sm text-gray-600">計測日</label>
                                                    <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                    <input type="date" id="measurement_month" name="measurement_month" v-model="form.measurement_month" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <div v-if="errors.measurement_month" class="mt-3 text-red-500 text-xs">{{ errors.measurement_month }}</div>
                                            </div>
                                            <div class="p-2 w-full text-center">
                                                <button class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg mr-5">登録</button>
                                                <Link as="button" class="text-white bg-gray-500 border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg ml-5" :href="route('growths.index')">
                                                    戻る
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                        <section class="text-gray-600 body-font relative">
                            <div class="container px-5 py-24 mx-auto">
                                <div class="w-full mx-auto overflow-auto">
                                    <h3 class="text-2xl font-semibold mb-4">成長記録</h3>
                                    <table class="table-auto w-full text-left whitespace-no-wrap" id="sort_table">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">　</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">身長</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">体重</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">胸囲</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">腹囲</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">頭囲</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">計測日</th>
                                            </tr>
                                        </thead>
                                        <tbody v-for="growth in growths" :key="growth.id">
                                            <tr>
                                                <span>
                                                    <td class="px-4 py-3">
                                                        <Link as="button" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg" :href="route('growths.edit', { growth: growth.id })">
                                                            編集
                                                        </Link>
                                                    </td>
                                                </span>
                                                <td class="px-4 py-3">{{ growth.height }}cm</td>
                                                <td class="px-4 py-3">{{ growth.weight }}kg</td>
                                                <td class="px-4 py-3">{{ growth.chest }}cm</td>
                                                <td class="px-4 py-3">{{ growth.abdomen }}cm</td>
                                                <td class="px-4 py-3">{{ growth.head }}cm</td>
                                                <td class="px-4 py-3">{{ dayjs(growth.measurement_month).format('YYYY/MM/DD') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
