<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import { ref, onMounted } from 'vue';

const props = defineProps({
    children: Object,
    currentUserRole: Boolean,
});
</script>
<template>
    <Head title="生徒一覧" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                生徒一覧
            </h2>
        </template>

        <FlashMessage />
        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font">
                            <div class="container px-5 py-24 mx-auto">
                                <div class="w-full mx-auto overflow-auto">
                                    <table class="table-auto w-full text-left whitespace-no-wrap" id="sort_table">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">　</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">名前</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">電話番号</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メールアドレス</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">入学日</th>
                                            </tr>
                                        </thead>
                                        <tbody v-for="child in children.data" :key="child.id">
                                            <tr>
                                                <span v-if="currentUserRole === true">
                                                    <td class="px-4 py-3">
                                                        <Link as="button" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg" :href="route('admin.child.edit', { child: child.id })">
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
                                                <td class="px-4 py-3">{{ child.name }}</td>
                                                <td class="px-4 py-3">{{ child.tel }}</td>
                                                <td class="px-4 py-3">{{ child.email }}</td>
                                                <td class="px-4 py-3">{{ child.admission_date }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="text-center">
                                <Pagination :links="props.children.links"></Pagination>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
