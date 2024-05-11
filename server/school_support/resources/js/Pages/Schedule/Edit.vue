<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch, computed, onMounted } from 'vue';
import { startOfWeek, addWeeks, format, eachDayOfInterval, isSunday } from 'date-fns';
import holidayJp from '@holiday-jp/holiday_jp';

const props = defineProps({
    subjects: Array,
    gradeClassId: Number,
});

const currentDate = ref(new Date());
const displayedWeek = ref(startOfWeek(currentDate.value, { weekStartsOn: 1 }));

// const weekDays = computed(() => {
//     return eachDayOfInterval({
//         start: displayedWeek.value,
//         end: addWeeks(displayedWeek.value, 1)
//     }).filter(day =>
//         !isSunday(day) && !holidayJp.isHoliday(day)
//     );
// });

// const weekSchedules = ref({});

// const initWeekSchedules = () => {
//     weekDays.value.forEach(day => {
//         const dateKey = formatDate(day);
//         if (!weekSchedules.value[dateKey]) {
//             weekSchedules.value[dateKey] = props.subjects.map(subject => ({ id: subject.id, name: subject.name, schedule: '' }));
//         }
//     });
// };



// watch(displayedWeek, initWeekSchedules, { immediate: true });

function nextWeek() {
    displayedWeek.value = addWeeks(displayedWeek.value, 1);
    initWeekSchedules();
}

function prevWeek() {
    displayedWeek.value = addWeeks(displayedWeek.value, -1);
    initWeekSchedules();
}

// function formatDate(date) {
//     return format(date, 'yyyy-MM-dd');
// }


const weekDays = computed(() => {
    return eachDayOfInterval({
        start: displayedWeek.value,
        end: addWeeks(displayedWeek.value, 1)
    }).filter(day => !isSunday(day) && !holidayJp.isHoliday(day));
});

const weekSchedules = ref({});

const initWeekSchedules = () => {
    weekDays.value.forEach(day => {
        const dateKey = formatDate(day);
        if (!weekSchedules.value[dateKey]) {
            weekSchedules.value[dateKey] = props.subjects.map(subject => ({
                id: subject.id,
                name: subject.name,
                grade_class_id: subject.grade_class_id,
                schedule: ''
            }));
            weekSchedules.value[dateKey]['other'] = [];
        }
    });
};

watch(displayedWeek, initWeekSchedules, { immediate: true });

function formatDate(date) {
    return format(date, 'yyyy-MM-dd');
}

const englishSuffixes = [
    'first', 'second', 'third', 'fourth', 'five', 'six', 'other'
];

const submitWeekSchedules = () => {
    const formattedData = Object.keys(weekSchedules.value).reduce((acc, date) => {
        const daySchedules = weekSchedules.value[date];
        acc[date] = {
            grade_class_id: props.gradeClassId  // 各日付のデータに gradeClassId を追加
        };
        daySchedules.forEach((scheduleItem, index) => {
            const suffix = index < 6 ? englishSuffixes[index] : 'other';
            if (suffix !== 'other') {
                acc[date][`subject_id_${suffix}`] = scheduleItem.schedule || '';
            }
        });
        // 'other' のデータを配列として追加
        acc[date]['subject_id_other'] = [daySchedules.other || ''];
        return acc;
    }, {});

    console.log('Final formatted data:', formattedData);  // 送信直前のデータ確認
    router.post('/schedules/bulkStore', { scheduleData: formattedData });
};
</script>
<style scoped>
ul {
  list-style-type: none;
  padding: 0;
}
li.drag-item {
  padding: 10px;
  margin: 5px 0;
  background-color: #f4f4f4;
  border: 1px solid #ccc;
  cursor: grab;
}
.week-grid {
  display: flex;
  flex-wrap: nowrap;
  justify-content: space-around;
  overflow-x: auto;
}

.day {
  flex: 0 0 14%;
  margin: 5px;
  padding: 10px;
  background: #f9f9f9;
  border: 1px solid #ddd;
  min-width: 120px;
}
.slots input {
  display: block;
  width: 100%;
  margin-top: 5px;
  padding: 8px;
}
</style>
<template>
    <Head title="時間割編集" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                時間割編集
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font relative">

                            <form @submit.prevent="submitForm">
                                <div class="week-navigation text-center">
                                    <button @click="prevWeek" class="mr-6 text-white bg-gray-500 border-0 py-2 px-4 focus:outline-none hover:bg-gray-600 rounded text-lg">前の週</button>
                                    <button @click="nextWeek" class="ml-6 text-white bg-blue-500 border-0 py-2 px-4 focus:outline-none hover:bg-blue-600 rounded text-lg">次の週</button>
                                </div>
                                <div class="week-grid">
                                    <div class="day" v-for="(day, index) in weekDays" :key="index">
                                        <!-- <input type="text" name="grade_class_id" value={{ props.gradeClassId }}> -->
                                        <h4>{{ formatDate(day) }}</h4>
                                        <div class="slots">
                                            <select v-for="item in weekSchedules[formatDate(day)]" v-model="item.schedule">
                                                <option disabled value="">科目を選択</option>
                                                <option v-for="subject in props.subjects" :value="subject.id">{{ subject.name }}</option>
                                            </select>
                                            <select v-model="weekSchedules[formatDate(day)].other">
                                                <option disabled value="">科目を選択</option>
                                                <option v-for="subject in props.subjects" :value="subject.id">{{ subject.name }}</option>
                                            </select>
                                        </div>
                                        <input type="radio" id="all_check" name="subject_id_all_check" value="1">
                                        <label for="all_check" class="mx-3 my-3">全ての時間割
                                        </label>
                                    </div>
                                </div>

                                <div class="my-5 text-center">
                                    <button @click="submitWeekSchedules" class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg mr-5">登録</button>
                                    <Link as="button" class="text-white bg-gray-500 border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg ml-5" :href="route('schedules.index')">
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
