<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import { ref, onMounted } from 'vue';
import dayjs from 'dayjs';

defineProps({
    gradeClassHistories: Array,
    gradeClasses: Array,
    children: Array,
    users: Array,
    currentUserRole: Boolean,
});
</script>
<template>
    <Head title="学年クラス替え" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                学年クラス替え
            </h2>
        </template>

        <FlashMessage />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font">
                            <div class="container px-5 py-24 mx-auto">
                                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                    <h3 class="text-2xl font-semibold mb-4">学年クラス一覧</h3>
                                    <table class="table-auto w-full text-left whitespace-no-wrap" id="sort_table">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">　</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">学年</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">クラス</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">担任</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">更新日</th>
                                            </tr>
                                        </thead>
                                        <tbody v-for="history in gradeClassHistories" :key="history.id">
                                            <tr>
                                                <span v-if="currentUserRole">
                                                    <td class="px-4 py-3">
                                                        <Link as="button" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg" :href="route('gradeClassHistories.edit', { history: history.id })">
                                                            編集
                                                        </Link>
                                                    </td>
                                                </span>
                                                <span v-else>
                                                    <td class="px-4 py-3">
                                                        <span as="button" class="flex mx-auto text-white bg-gray-500 border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg">
                                                            編集
                                                        </span>
                                                    </td>
                                                </span>
                                                <td class="px-4 py-3">{{ history.grade_class.grade_name }}</td>
                                                <td class="px-4 py-3">{{ history.grade_class.class_name }}</td>
                                                <td class="px-4 py-3">{{ history.user.name}}</td>
                                                <td class="px-4 py-3">{{ dayjs(history.updated_at).format('YYYY-MM-DD HH:mm:ss') }}</td>
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
