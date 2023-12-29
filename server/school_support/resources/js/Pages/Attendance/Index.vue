<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import { ref, onMounted } from 'vue';
import SearchForm from '@/Components/SearchForm.vue';

const props = defineProps({
    gradeClasses: Array,
    children: Object
});
</script>
<template>
    <Head title="登下校一覧" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                登下校一覧
            </h2>
        </template>

        <FlashMessage />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font">
                            <SearchForm v-if="props.gradeClasses" :gradeClasses="props.gradeClasses" />
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font">
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 border border-gray-300">生徒名</th>
                                            <th class="px-4 py-2 border border-gray-300">クラス名</th>
                                            <th class="px-4 py-2 border border-gray-300">出欠状況</th>
                                            <th class="px-4 py-2 border border-gray-300">欠席理由</th>
                                            <th class="px-4 py-2 border border-gray-300">登校時間</th>
                                            <th class="px-4 py-2 border border-gray-300">下校時間</th>
                                            <th class="px-4 py-2 border border-gray-300">教員メモ</th>
                                            <th class="px-4 py-2 border border-gray-300">保護者メモ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="child in children" :key="child.id">
                                            <td class="border px-4 py-2 border-gray-300">{{ child.name }}</td>
                                            <td class="border px-4 py-2 border-gray-300">
                                                <td class="border px-4 py-2 border-gray-300">
                                                    {{ child.gradeClassHistories?.[0]?.gradeClass?.class_name || 'データなし' }}
                                                </td>
                                            </td>
                                            <td class="border px-4 py-2 border-gray-300">
                                                <span v-if="child.daily?.attendance_status === 0">なし</span>
                                                <span v-else-if="child.daily?.attendance_status === 1">出席</span>
                                                <span v-else-if="child.daily?.attendance_status === 2">遅刻</span>
                                                <span v-else-if="child.daily?.attendance_status === 3">早退</span>
                                                <span v-else-if="child.daily?.attendance_status === 4">欠席</span>
                                                <span v-else>@TODOステータスなし</span>
                                            </td>
                                            <td class="border px-4 py-2 border-gray-300">{{ child.daily?.absence_reason }}</td>
                                            <td class="border px-4 py-2 border-gray-300">{{ child.daily?.start_time }}</td>
                                            <td class="border px-4 py-2 border-gray-300">{{ child.daily?.end_time }}</td>
                                            <td class="border px-4 py-2 border-gray-300">{{ child.daily?.admin_memo }}</td>
                                            <td class="border px-4 py-2 border-gray-300">{{ child.daily?.parent_memo }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
