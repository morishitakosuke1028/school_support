<script setup>
import AuthenticatedChildLayout from '@/Layouts/AuthenticatedChildLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed, watch, reactive } from 'vue';
import holidayJp from '@holiday-jp/holiday_jp';

const props = defineProps({
    gradeClasses: Array,
    homeworks: Object
});

const formatDate = (date) => {
    const year = date.getFullYear();
    const month = date.getMonth() + 1; // 0 から始まる月を 1 から始まる月に変換
    const day = date.getDate();
    return `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
};

const currentYear = new Date().getFullYear();
const currentMonth = new Date().getMonth();
const homeworkData = reactive({});

// props.homeworks を使って homeworkData を初期化
props.homeworks.forEach(hw => {
    const hwDate = formatDate(new Date(hw.homework_day));
    homeworkData[hwDate] = {
        reading: hw.reading,
        language_drill: hw.language_drill,
        arithmetic: hw.arithmetic,
        diary: hw.diary,
        ipad: hw.ipad,
        other: hw.other,
        homework_day: hw.homework_day,
        grade_class_id: hw.grade_class_id
    };
});

const calendarData = reactive({
    year: currentYear,
    month: currentMonth
});

const changeMonth = (year, month) => {
    calendarData.year = year;
    calendarData.month = month;
};

const getDaysInMonth = (year, month) => {
    const date = new Date(year, month, 1);
    const days = [];
    while (date.getMonth() === month) {
        days.push(new Date(date));
        date.setDate(date.getDate() + 1);
    }
    return days;
};

const calendarDays = computed(() => {
    return getDaysInMonth(calendarData.year, calendarData.month);
});

const transformedData = {};
for (const [key, value] of Object.entries(homeworkData)) {
    if (key.match(/^\d{4}-\d{2}-\d{2}$/)) { // 日付形式のキーのみをチェック
        transformedData[key] = { ...value };
        ['reading', 'language_drill', 'arithmetic', 'diary'].forEach(field => {
            if (transformedData[key][field] === false) {
                transformedData[key][field] = null;
            }
        });
    }
}

const getYearsRange = computed(() => {
    const startYear = currentYear - 5;
    const endYear = currentYear + 5;
    return Array.from({ length: endYear - startYear + 1 }, (_, i) => startYear + i);
});

const monthNames = ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"];
const displayedMonth = computed(() => {
    return `${calendarData.year}年 ${monthNames[calendarData.month]}`;
});

const weekDays = ['日', '月', '火', '水', '木', '金', '土'];

const getDayWithHoliday = (date) => {
    const dayOfWeek = weekDays[date.getDay()];
    const holiday = holidayJp.isHoliday(date) ? ' (祝)' : '';
    return `${dayOfWeek}${holiday}`;
};

const isSunday = (date) => date.getDay() === 0;
const isSaturday = (date) => date.getDay() === 6;

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

    <AuthenticatedChildLayout>
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
                                        <td>{{ homeworkData[formatDate(day)]?.reading ? '✔️' : '❌' }}</td>
                                        <td>{{ homeworkData[formatDate(day)]?.language_drill ? '✔️' : '❌' }}</td>
                                        <td>{{ homeworkData[formatDate(day)]?.arithmetic ? '✔️' : '❌' }}</td>
                                        <td>{{ homeworkData[formatDate(day)]?.diary ? '✔️' : '❌' }}</td>
                                        <td>{{ homeworkData[formatDate(day)]?.ipad }}</td>
                                        <td>{{ homeworkData[formatDate(day)]?.other }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedChildLayout>
</template>

