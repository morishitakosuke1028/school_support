<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive, ref } from 'vue'

const props = defineProps({
    gradeClassHistory: Object,
    children: Object,
    users: Object,
})

const form = reactive({
    id: props.gradeClassHistory.id,
    user_id: props.gradeClassHistory.user_id,
    child_id: props.gradeClassHistory.child_id,
})

const updateGradeClassHistory = id => {
    router.put(route('gradeClassHistories.update', { gradeClassHistory: form.id }), form)
}
const deleteGradeClassHistory = id => {
    router.delete(route('gradeClassHistories.destroy', { gradeClassHistory: id }), {
        onBefore: () => confirm('本当に削除しますか？')
    })
}
</script>

<template>
    <Head title="学年クラス替え" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                学年クラス替え
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font relative flex-auto">

                            <form @submit.prevent="updateGradeClassHistory(form.id)">
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="user_id" class="leading-7 text-sm text-gray-600">担任</label>
                                                    <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                    <div>
                                                        <select v-model="form.user_id">
                                                            <option v-for="user in props.users" :key="user.id" :value="user.id">{{ user.name }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex flex-wrap -m-2">
                                                <div class="p-2 w-full">
                                                    <div class="relative">
                                                        <label for="child_id" class="leading-7 text-sm text-gray-600">生徒名</label>
                                                        <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                        <div>
                                                            <select multiple>
                                                                <option v-for="child in props.children" :key="child.id" :value="child.id">{{ child.name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="p-2 w-full">
                                                    <div class="relative">
                                                        <label for="child_id" class="leading-7 text-sm text-gray-600">生徒名</label>
                                                        <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                        <div>
                                                            <select multiple v-model="form.child_id">
                                                                <option v-for="child in props.children" :key="child.id" :value="child.id">{{ child.name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full text-center">
                                                <button class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg mr-5">更新</button>
                                                <Link as="button" class="text-white bg-gray-500 border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg ml-5" :href="route('gradeClassHistories.index')">
                                                    戻る
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="p-2 w-full">
                                <button @click="deleteGradeClassHistory(gradeClassHistory.id)" class="flex mx-auto text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">削除する</button>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
