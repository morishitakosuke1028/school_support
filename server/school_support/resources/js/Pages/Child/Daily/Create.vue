<script setup>
import AuthenticatedChildLayout from '@/Layouts/AuthenticatedChildLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { reactive, onMounted } from 'vue'

const props = defineProps({
    childId: Number,
});

const form = reactive({
    child_id: props.childId,
    attendance_status: null,
    absence_reason: null,
    start_time: null,
    end_time: null,
    parent_memo: null,
    date: null
})

const getCurrentDate = () => {
    const today = new Date();
    const dd = String(today.getDate()).padStart(2, '0');
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const yyyy = today.getFullYear();
    return `${yyyy}-${mm}-${dd}`;
};

const combineDateTime = (date, time) => {
    return time ? `${date} ${time}` : null;
};

onMounted(() => {
    form.date = getCurrentDate();
});

const storeDaily = () => {
    const startDateTime = combineDateTime(form.date, form.start_time);
    const endDateTime = combineDateTime(form.date, form.end_time);

    const data = {
        child_id: form.child_id,
        attendance_status: form.attendance_status,
        absence_reason: form.absence_reason,
        start_time: startDateTime,
        end_time: endDateTime,
        parent_memo: form.parent_memo,
    };

    router.post('/child/daily', data);
};
</script>

<template>
    <Head title="出欠申請" />

    <AuthenticatedChildLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                出欠申請
            </h2>
        </template>

        <FlashMessage />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="storeDaily">
                                <input type="hidden" id="child_id" name="child_id" v-model="form.child_id" required="required" />
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="class_name" class="leading-7 text-sm text-gray-600">日付を入力してください。</label>
                                                    <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                    <input type="date" id="date" name="date" v-model="form.date" class="w-full bg-white-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <p>出欠の種類を選択してください。<span class="font-medium text-sm text-red-700">（必須）</span></p>
                                                <div class="relative">
                                                    <input type="radio" id="attendance_status1" name="attendance_status" v-model="form.attendance_status" value="2" class="hidden peer">
                                                    <label for="attendance_status1" class="flex flex-col w-full max-w-lg mx-auto text-center border-2 rounded-2xl border-gray-900 p-2 my-4 text-3xl hover:bg-yellow-200 peer-checked:bg-green-200">遅刻</label>
                                                </div>
                                                <div class="relative">
                                                    <input type="radio" id="attendance_status2" name="attendance_status" v-model="form.attendance_status" value="3" class="hidden peer">
                                                    <label for="attendance_status2" class="flex flex-col w-full max-w-lg mx-auto text-center border-2 rounded-2xl border-gray-900 p-2 my-4 text-3xl hover:bg-yellow-200 peer-checked:bg-green-200">早退</label>
                                                </div>
                                                <div class="relative">
                                                    <input type="radio" id="attendance_status3" name="attendance_status" v-model="form.attendance_status" value="4" class="hidden peer">
                                                    <label for="attendance_status3" class="flex flex-col w-full max-w-lg mx-auto text-center border-2 rounded-2xl border-gray-900 p-2 my-4 text-3xl hover:bg-yellow-200 peer-checked:bg-green-200">欠席</label>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full" v-if="form.attendance_status === '2'">
                                                <div class="relative">
                                                    <label for="start_time" class="leading-7 text-sm text-gray-600">遅刻の出席時間を入力してください。</label>
                                                    <input type="time" id="start_time" name="start_time" v-model="form.start_time" class="w-full bg-white-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                            <div class="p-2 w-full" v-if="form.attendance_status === '3'">
                                                <div class="relative">
                                                    <label for="end_time" class="leading-7 text-sm text-gray-600">早退の下校時間を入力してください。</label>
                                                    <input type="time" id="end_time" name="end_time" v-model="form.start_time" class="w-full bg-white-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                            <div class="p-2 w-full" v-if="form.attendance_status === '4'">
                                                <div class="relative">
                                                    <label for="absence_reason" class="leading-7 text-sm text-gray-600">欠席理由を入力してください。</label>
                                                    <input type="text" id="absence_reason" name="absence_reason" v-model="form.absence_reason" class="w-full bg-white-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="parent_memo" class="leading-7 text-sm text-gray-600">備考等を入力してください。</label>
                                                    <input type="text" id="parent_memo" name="parent_memo" v-model="form.parent_memo" class="w-full bg-white-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                            <div class="p-2 w-full text-center">
                                                <button class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg mr-5">申請</button>
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
    </AuthenticatedChildLayout>
</template>
