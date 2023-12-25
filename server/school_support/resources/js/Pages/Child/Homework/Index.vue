<script setup>
import AuthenticatedChildLayout from '@/Layouts/AuthenticatedChildLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import holidayJp from '@holiday-jp/holiday_jp';

const props = defineProps({
    homework: Object
});

const selectedDate = ref(new Date());

// セレクトボックスで選択可能な日付のリストを生成
const availableDates = computed(() => {
    // ここで現在の月の日付のリストを生成
    const dates = [];
    const currentMonth = new Date().getMonth();
    const currentYear = new Date().getFullYear();
    const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

    for (let day = 1; day <= daysInMonth; day++) {
        dates.push(new Date(currentYear, currentMonth, day));
    }
    return dates;
});

// 選択された日付の宿題データを取得
const selectedHomeworkData = computed(() => {
    return props.homework.find(hw => {
        const hwDate = new Date(hw.homework_day);
        return hwDate.getDate() === selectedDate.value.getDate() &&
               hwDate.getMonth() === selectedDate.value.getMonth() &&
               hwDate.getFullYear() === selectedDate.value.getFullYear();
    });
});

watch(selectedDate, () => {
    // 選択された日付が変更されたときの処理
});
</script>
<style>
.homework-table {
  width: 100%;
  border-collapse: collapse;
}

.homework-table th, .homework-table td {
  border: 1px solid #ddd;
  padding: 8px;
}

.homework-table th {
  background-color: #f3f3f3;
  text-align: left;
}

.sunday {
  color: red; /* 日曜日を赤色で表示 */
}

.saturday {
  color: #007bff; /* 土曜日を水色で表示 */
}

.holiday {
  color: red; /* 祝日を赤色で表示 */
}
</style>
<template>
    <Head title="宿題" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                宿題
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font relative">
                            <div class="date-selector my-5">
                                <span>対象の年月：　</span>
                                <select v-model="calendarData.year">
                                <option v-for="year in getYearsRange" :key="year" :value="year">{{ year }}</option>
                                </select>
                                <span class="mx-3">年 </span>
                                <select v-model="calendarData.month">
                                <option v-for="(monthName, index) in monthNames" :key="index" :value="index">{{ monthName }}</option>
                                </select>
                                <span class="mx-3">月</span>
                            </div>
                            <h3 class="text-lg font-semibold mb-5">{{ displayedMonth }}</h3>
                            <table class="homework-table" :key="`${calendarData.year}-${calendarData.month}`">
                                <thead>
                                    <tr>
                                    <th>日付</th>
                                    <th>音読</th>
                                    <th>漢字ドリル</th>
                                    <th>算数プリント</th>
                                    <th>日記</th>
                                    <th>iPad</th>
                                    <th>その他</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="day in calendarDays" :key="day.getDate()">
                                        <td :class="{ 'sunday': isSunday(day), 'saturday': isSaturday(day), 'holiday': holidayJp.isHoliday(day) }">
                                            {{ day.getDate() }}日 ({{ getDayWithHoliday(day) }})
                                        </td>
                                        <td>
                                            <input
                                                type="checkbox"
                                                :checked="homeworkData[formatDate(day)] && homeworkData[formatDate(day)].reading"
                                                @input="event => {
                                                    if (homeworkData[formatDate(day)]) {
                                                        homeworkData[formatDate(day)].reading = event.target.checked;
                                                    }}"
                                            >
                                        </td>
                                        <td>
                                            <input
                                                type="checkbox"
                                                :checked="homeworkData[formatDate(day)] && homeworkData[formatDate(day)].language_drill"
                                                @input="event => {
                                                    if (homeworkData[formatDate(day)]) {
                                                        homeworkData[formatDate(day)].language_drill = event.target.checked;
                                                    }}"
                                            >
                                        </td>
                                        <td>
                                            <input
                                                type="checkbox"
                                                :checked="homeworkData[formatDate(day)] && homeworkData[formatDate(day)].arithmetic"
                                                @input="event => {
                                                    if (homeworkData[formatDate(day)]) {
                                                        homeworkData[formatDate(day)].arithmetic = event.target.checked;
                                                    }}"
                                            >
                                        </td>
                                        <td>
                                            <input
                                                type="checkbox"
                                                :checked="homeworkData[formatDate(day)] && homeworkData[formatDate(day)].diary"
                                                @input="event => {
                                                    if (homeworkData[formatDate(day)]) {
                                                        homeworkData[formatDate(day)].diary = event.target.checked;
                                                    }}"
                                            >
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                :value="homeworkData[formatDate(day)] ? homeworkData[formatDate(day)].ipad : ''"
                                                @input="event => {
                                                    if (homeworkData[formatDate(day)]) {
                                                        homeworkData[formatDate(day)].ipad = event.target.value;
                                                    }}"
                                            >
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                :value="homeworkData[formatDate(day)] ? homeworkData[formatDate(day)].other : ''"
                                                @input="event => {
                                                    if (homeworkData[formatDate(day)]) {
                                                        homeworkData[formatDate(day)].other = event.target.value;
                                                    }}"
                                            >
                                        </td>
                                        <input
                                            type="hidden"
                                            :value="homeworkData[formatDate(day)]?.homework_day"
                                            @input="event => homeworkData[formatDate(day)].homework_day = event.target.value"
                                        >
                                        <input
                                            type="hidden"
                                            :value="homeworkData[formatDate(day)]?.grade_class_id"
                                            @input="event => homeworkData[formatDate(day)].grade_class_id = event.target.value"
                                        >
                                    </tr>
                                </tbody>
                            </table>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

