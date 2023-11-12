<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import { ref, onMounted } from 'vue';

const props = defineProps({
    gradeClasses: Object,
    currentUserRole: Boolean,
});
</script>
<template>
    <Head title="学年クラスマスタ" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                学年クラスマスタ
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
                                    <table class="table-auto w-full text-left whitespace-no-wrap" id="sort_table">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">　</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">学年</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">クラス</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">作成日</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">更新日</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="gradeClasses && gradeClasses.data" v-for="gradeClass in gradeClasses.data" :key="gradeClass.id">
                                            <tr>
                                                <span v-if="currentUserRole">
                                                    <td class="px-4 py-3">
                                                        <Link as="button" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg" :href="route('users.edit', { user: user.id })">
                                                            編集する
                                                        </Link>
                                                    </td>
                                                </span>
                                                <span v-else>
                                                    <td class="px-4 py-3">
                                                        <span as="button" class="flex mx-auto text-white bg-gray-500 border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg">
                                                            編集する
                                                        </span>
                                                    </td>
                                                </span>
                                                <td class="px-4 py-3">{{ gradeClass.grade_name }}</td>
                                                <td class="px-4 py-3">{{ gradeClass.class_name }}</td>
                                                <td class="px-4 py-3">{{ gradeClass.created_at }}</td>
                                                <td class="px-4 py-3">{{ gradeClass.updated_at }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- <Pagination :links="gradeClasses.links"></Pagination> -->
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
