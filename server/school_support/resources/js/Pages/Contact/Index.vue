<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    children: Object,
});
</script>
<template>
    <Head title="連絡帳" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                連絡帳
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
                                    <h3 class="text-2xl font-semibold mb-4">生徒一覧</h3>
                                    <table class="table-auto w-full text-left whitespace-no-wrap" id="sort_table">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">　</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">学年</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">クラス</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">生徒名</th>
                                            </tr>
                                        </thead>
                                        <tbody v-for="child in children" :key="child.id">
                                            <tr>
                                                <span>
                                                    <td class="px-4 py-3">
                                                        <Link as="button" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg" :href="route('contacts.create', { contact: child.id })">
                                                            連絡
                                                        </Link>
                                                    </td>
                                                </span>
                                                <td class="px-4 py-3">{{ child.grade_name }}</td>
                                                <td class="px-4 py-3">{{ child.class_name }}</td>
                                                <td class="px-4 py-3">{{ child.name }}</td>
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
