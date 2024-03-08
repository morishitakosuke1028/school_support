<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive } from 'vue'

defineProps({
    errors: Object
})

const form = reactive({
    school_id: '1',
    grade_name: null,
    class_name: null,
})

const storeGradeClass = () => {
    router.post('/gradeClasses', form)
}
</script>

<template>
    <Head title="学年クラス登録" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                学年クラス登録
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="storeGradeClass">
                                <input type="hidden" id="school_id" name="status" v-model="form.school_id" required="required" />
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="grade_name" class="leading-7 text-sm text-gray-600">学年名</label>
                                                    <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                    <input type="text" id="grade_name" name="grade_name" v-model="form.grade_name" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <div v-if="errors.grade_name" class="mt-3 text-red-500 text-xs">{{ errors.grade_name }}</div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="class_name" class="leading-7 text-sm text-gray-600">クラス名</label>
                                                    <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                    <input type="text" id="class_name" name="class_name" v-model="form.class_name" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <div v-if="errors.class_name" class="mt-3 text-red-500 text-xs">{{ errors.class_name }}</div>
                                            </div>
                                            <div class="p-2 w-full text-center">
                                                <button class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg mr-5">登録</button>
                                                <Link as="button" class="text-white bg-gray-500 border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg ml-5" :href="route('gradeClasses.index')">
                                                    戻る
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
