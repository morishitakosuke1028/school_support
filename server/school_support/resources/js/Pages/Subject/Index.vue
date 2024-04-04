<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import dayjs from 'dayjs';

const props = defineProps({
    subjects: Object,
    currentUserRole: Boolean,
});
</script>
<template>
    <Head title="教科管理" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                教科管理
            </h2>
        </template>

        <FlashMessage />
        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font">
                            <div class="container px-5 py-24 mx-auto">
                                <div class="flex pl-4 my-4 w-full mx-auto">
                                    <Link as="button" class="inline-flex items-center px-4 py-2 bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" :href="route('subjects.create')">
                                        新規作成
                                    </Link>
                                </div>

                                <div class="w-full mx-auto overflow-auto">
                                    <table class="table-auto w-full text-left whitespace-no-wrap" id="sort_table">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">　</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">ID</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">教科</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">作成日</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="subjects && subjects.data" v-for="subject in subjects.data" :key="subject.id">
                                            <tr>
                                                <span v-if="currentUserRole">
                                                    <td class="px-4 py-3">
                                                        <Link as="button" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg" :href="route('subject.edit', { subject: subject.id })">
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
                                                <td class="px-4 py-3">{{ subject.id }}</td>
                                                <td class="px-4 py-3">{{ subject.name }}</td>
                                                <td class="px-4 py-3">{{ dayjs(subject.created_at).format('YYYY-MM-DD HH:mm:ss') }}</td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="text-center">
                                <Pagination :links="props.subjects.links"></Pagination>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
