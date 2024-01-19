<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import { toRefs, reactive, onMounted } from 'vue';
import SearchForm from '@/Components/SearchForm.vue';

const props = defineProps({
    gradeClasses: Array,
    children: Array
});

const { children } = toRefs(props);
const editableChildren = reactive(children.value.map(child => {
    const latestDaily = child.dailies && child.dailies.length > 0 ? child.dailies[child.dailies.length - 1] : null;

    // 日付と時間を分割してフォーマット
    const formatTime = (datetime) => {
        if (!datetime) return '';
        const time = new Date(datetime);
        return time.getHours().toString().padStart(2, '0') + ':' + time.getMinutes().toString().padStart(2, '0');
    };

    return {
        ...child,
        daily: latestDaily ? {
            ...latestDaily,
            start_time: formatTime(latestDaily.start_time),
            end_time: formatTime(latestDaily.end_time)
        } : {
            attendance_status: null,
            absence_reason: '',
            start_time: '',
            end_time: '',
            admin_memo: '',
            parent_memo: '',
            date_use: '',
            entry_method: '1',
            update_method: '1',
        }
    };
}));

onMounted(() => {
    console.log(editableChildren);
});
const defaultDate = new Date().toISOString().slice(0, 10);
const searchDate = props.searchDate || defaultDate;
const submitData = () => {
    const data = {
        dailies: editableChildren.map(child => {
            const startTime = child.daily?.start_time ? searchDate + ' ' + child.daily.start_time : null;
            const endTime = child.daily?.end_time ? searchDate + ' ' + child.daily.end_time : null;

            return {
                id: child.daily.id,
                child_id: child.id,
                attendance_status: child.daily?.attendance_status || null,
                absence_reason: child.daily?.absence_reason || '',
                date_use: searchDate,
                start_time: startTime,
                end_time: endTime,
                admin_memo: child.daily?.admin_memo || '',
                parent_memo: child.daily?.parent_memo || '',
                entry_method: '1',
                update_method: '1'
            };
        })
    };

    router.post('/attendance', data);
};
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
                            <SearchForm />
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
                            <form @submit.prevent="submitData">
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
                                            <tr v-for="child in editableChildren" :key="child.id">
                                                <input type="hidden" id="entry_method" name="entry_method" v-model="child.daily.entry_method" />
                                                <input type="hidden" id="update_method" name="update_method" v-model="child.daily.update_method" />
                                                <td class="border px-4 py-2 border-gray-300">{{ child.name }}</td>
                                                <td class="border px-4 py-2 border-gray-300">
                                                    <span v-if="child.grade_class_histories && child.grade_class_histories.length > 0">
                                                        {{ child.grade_class_histories[0].grade_class.grade_name }} {{ child.grade_class_histories[0].grade_class.class_name }}
                                                    </span>
                                                    <span v-else></span>
                                                </td>
                                                <td class="border px-4 py-2 border-gray-300">
                                                    <select v-model="child.daily.attendance_status">
                                                        <option value="0">なし</option>
                                                        <option value="1">出席</option>
                                                        <option value="2">遅刻</option>
                                                        <option value="3">早退</option>
                                                        <option value="4">欠席</option>
                                                    </select>
                                                </td>
                                                <td class="border px-4 py-2 border-gray-300">
                                                    <input type="text" v-model="child.daily.absence_reason" class="border border-gray-300" />
                                                </td>
                                                <td class="border px-4 py-2 border-gray-300">
                                                    <input type="time" v-model="child.daily.start_time" class="border border-gray-300" />
                                                </td>
                                                <td class="border px-4 py-2 border-gray-300">
                                                    <input type="time" v-model="child.daily.end_time" class="border border-gray-300" />
                                                </td>
                                                <td class="border px-4 py-2 border-gray-300">
                                                    <textarea id="admin_memo" name="admin_memo" v-model="child.daily.admin_memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                                </td>
                                                <td class="border px-4 py-2 border-gray-300">
                                                    <textarea id="parent_memo" name="parent_memo" v-model="child.daily.parent_memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="p-2 w-full text-center">
                                        <button class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg mr-5">登録</button>
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
