<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { reactive, computed, watch, onMounted } from 'vue';
import holidayJp from '@holiday-jp/holiday_jp';

const props = defineProps({
    gradeClass: Object,
    homework: Object
})

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
    const year = date.getFullYear();
    const month = date.getMonth() + 1; // 0 から始まる月を 1 から始まる月に変換
    const day = date.getDate();
    return `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
};

// const updateGradeClass = id => {
//     router.put(route('homeworks.update', { homework: id }), form)
// }


const calendarDays = computed(() => {
    return getDaysInMonth(calendarData.year, calendarData.month);
});

const homeworkData = reactive({
    id: props.homework.id,
    grade_class_id: props.homework.grade_class_id,
    homework_day: props.homework.homework_day,
    reading: props.homework.reading,
    language_drill: props.homework.language_drill,
    arithmetic: props.homework.arithmetic,
    diary: props.homework.diary,
    ipad: props.homework.ipad,
    other: props.homework.other,
});

onMounted(() => {
  updateHomeworkData();
});

watch(() => [calendarData.year, calendarData.month], () => {
  updateHomeworkData();
});

function updateHomeworkData() {
  calendarDays.value.forEach(day => {
    const formattedDay = formatDate(day);
    if (!homeworkData[formattedDay]) {
      homeworkData[formattedDay] = {
        reading: false,
        language_drill: false,
        arithmetic: false,
        diary: false,
        ipad: '',
        other: '',
        homework_day: formattedDay,
        grade_class_id: props.gradeClass.id
      };
    }
  });
}

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

const submitForm = async () => {
  const filteredData = {};
  for (const [key, value] of Object.entries(homeworkData)) {
    if (key.match(/^\d{4}-\d{2}-\d{2}$/)) { // 日付形式のキーのみをチェック
      filteredData[key] = { ...value };
      ['reading', 'language_drill', 'arithmetic', 'diary'].forEach(field => {
        // ブール値を文字列 '1' または '' に変換
        filteredData[key][field] = filteredData[key][field] ? '1' : '';
      });
    }
  }

  const url = '/homeworks/bulk';
  try {
    await router.post(url, { homeworkData: filteredData });
  } catch (error) {
    console.error('Error on form submission:', error);
  }
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
                                                type="text"
                                                :value="homeworkData[formatDate(day)]?.homework_day"
                                                @input="event => homeworkData[formatDate(day)].homework_day = event.target.value"
                                            >
                                            <input
                                                type="text"
                                                :value="homeworkData[formatDate(day)]?.grade_class_id"
                                                @input="event => homeworkData[formatDate(day)].grade_class_id = event.target.value"
                                            >
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
