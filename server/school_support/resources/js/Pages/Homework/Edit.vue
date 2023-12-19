<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { reactive, computed } from 'vue';
import holidayJp from '@holiday-jp/holiday_jp';

// const props = defineProps({
//     gradeClass: Object,
//     homework: Object
// })

const { props } = usePage();
const currentYear = new Date().getFullYear();
const currentMonth = new Date().getMonth();

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

const formatDate = (date) => {
    return date.toISOString().split('T')[0];
};

const form = reactive({
    // id: props.homework.id,
    // grade_class_id: props.homework.grade_class_id,
    // homework_day: props.homework.homework_day,
    // reading: props.homework.reading,
    // language_drill: props.homework.language_drill,
    // arithmetic: props.homework.arithmetic,
    // diary: props.homework.diary,
    // ipad: props.homework.ipad,
    // other: props.homework.other,
    id: props.homework?.id ?? null,
    grade_class_id: props.homework?.grade_class_id ?? '',
    homework_day: props.homework?.homework_day ?? '',
    reading: props.homework?.reading ?? false,
    language_drill: props.homework?.language_drill ?? false,
    arithmetic: props.homework?.arithmetic ?? false,
    diary: props.homework?.diary ?? false,
    ipad: props.homework?.ipad ?? '',
    other: props.homework?.other ?? '',
})

const updateGradeClass = id => {
    router.put(route('homeworks.update', { homework: id }), form)
}

const calendarDays = computed(() => {
  return getDaysInMonth(calendarData.year, calendarData.month);
});

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

const submitForm = () => {
    const url = form.id ? `/homeworks/${form.id}` : '/homeworks';
    router.post(url, form);
};
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
    <Head title="宿題編集" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                宿題編集
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
                            <form @submit.prevent="submitForm">
                                <h3 class="text-lg font-semibold mb-5">{{ displayedMonth }}</h3>
                                <table class="homework-table">
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
                                            <td><input type="checkbox" :name="'homework[' + day.getDate() + '][reading]'"></td>
                                            <td><input type="checkbox" :name="'homework[' + day.getDate() + '][language_drill]'"></td>
                                            <td><input type="checkbox" :name="'homework[' + day.getDate() + '][arithmetic]'"></td>
                                            <td><input type="checkbox" :name="'homework[' + day.getDate() + '][diary]'"></td>
                                            <td><input type="text" :name="'homework[' + day.getDate() + '][ipad]'" placeholder="iPad"></td>
                                            <td><input type="text" :name="'homework[' + day.getDate() + '][other]'" placeholder="その他"></td>
                                            <input type="hidden" :name="'homework[' + day.getDate() + '][homework_day]'" :value="formatDate(day)">
                                            <input type="hidden" :name="'homework[' + day.getDate() + '][grade_class_id]'" :value="props.gradeClass.id">
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="my-5 text-center">
                                    <button class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg mr-5">登録</button>
                                    <Link as="button" class="text-white bg-gray-500 border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg ml-5" :href="route('homeworks.index')">
                                        戻る
                                    </Link>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
