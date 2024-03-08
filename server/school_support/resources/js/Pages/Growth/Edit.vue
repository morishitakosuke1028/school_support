<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive } from 'vue'

const props = defineProps({
    errors: Object,
    growth: Object,
    child: Object,
})
const form = reactive({
    id: props.growth.id,
    child_id: props.growth.child_id,
    height: props.growth.height,
    weight: props.growth.weight,
    chest: props.growth.chest,
    abdomen: props.growth.abdomen,
    head: props.growth.head,
    measurement_month: props.growth.measurement_month.slice(0, 10),
})

const updateGrowth = id => {
    router.put(route('growths.update', { growth: id }), form)
}

const deleteGrowth = id => {
    router.delete(route('growths.destroy', { growth: id }), {
        onBefore: () => confirm('本当に削除しますか？')
    })
}
</script>

<template>
    <Head title="成長記録登録" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ child.name }}さんの成長記録編集
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="updateGrowth(form.id)">
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
                                                <button class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg mr-5">更新</button>
                                                <Link as="button" class="text-white bg-gray-500 border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg ml-5" :href="route('growths.index')">
                                                    戻る
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="p-2 w-full">
                                <button @click="deleteGrowth(growth.id)" class="flex mx-auto text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">削除する</button>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
