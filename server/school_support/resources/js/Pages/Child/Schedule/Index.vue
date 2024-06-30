<script setup>
import AuthenticatedChildLayout from '@/Layouts/AuthenticatedChildLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, watch, computed, onMounted } from 'vue';
import { addDays, startOfWeek, addWeeks, format, eachDayOfInterval, isSunday } from 'date-fns';

const props = defineProps({
    subjects: Array,
    schedules: Object
});

const currentDate = ref(new Date());
const displayedWeek = ref(startOfWeek(currentDate.value, { weekStartsOn: 1 }));

function nextWeek(event) {
    event.preventDefault();
    displayedWeek.value = addWeeks(displayedWeek.value, 1);
    initWeekSchedules();
}

function prevWeek(event) {
    event.preventDefault();
    displayedWeek.value = addWeeks(displayedWeek.value, -1);
    initWeekSchedules();
}

const weekDays = computed(() => {
    const start = startOfWeek(displayedWeek.value, { weekStartsOn: 1 });
    const end = addDays(start, 5);
    return eachDayOfInterval({ start, end });
});

const weekSchedules = ref({});

const initWeekSchedules = () => {
    weekDays.value.forEach(day => {
        const dateKey = formatDate(day);
        const scheduleForDate = props.schedules.find(schedule => formatDate(new Date(schedule.schedule_date)) === dateKey);

        if (scheduleForDate) {
            weekSchedules.value[dateKey] = [
                { id: 'first', schedule: scheduleForDate.subject_id_first || '' },
                { id: 'second', schedule: scheduleForDate.subject_id_second || '' },
                { id: 'third', schedule: scheduleForDate.subject_id_third || '' },
                { id: 'fourth', schedule: scheduleForDate.subject_id_fourth || '' },
                { id: 'fifth', schedule: scheduleForDate.subject_id_five || '' },
                { id: 'sixth', schedule: scheduleForDate.subject_id_six || '' },
                { id: 'other', schedule: scheduleForDate.subject_id_other ? [scheduleForDate.subject_id_other] : [] }
            ];
            weekSchedules.value[dateKey].allChecked = scheduleForDate.subject_id_all_check === 1;
        } else {
            weekSchedules.value[dateKey] = props.subjects.map(subject => ({
                id: subject.id,
                name: subject.name,
                grade_class_id: subject.grade_class_id,
                schedule: ''
            }));
            weekSchedules.value[dateKey].push({ id: 'other', schedule: '' });
            weekSchedules.value[dateKey].allChecked = false;
        }
    });
};

watch(displayedWeek, initWeekSchedules, { immediate: true });

function formatDate(date) {
    return format(date, 'yyyy-MM-dd');
}

function getSubjectNameById(subjectId) {
    const subject = props.subjects.find(subject => subject.id === subjectId);
    return subject ? subject.name : '';
}
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

.day h4 {
  border-bottom: solid 1px black;
}

.slots p {
  display: block;
  width: 100%;
  padding: 8px;
  border-bottom: solid 1px black;
  border-right: solid 1px black;
  border-left: solid 1px black;
}
</style>
<template>
    <Head title="時間割編集" />

    <AuthenticatedChildLayout>
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
                            <form @submit.prevent="submitWeekSchedules">
                                <div class="week-navigation text-center">
                                    <button @click="prevWeek" class="mr-6 text-white bg-gray-500 border-0 py-2 px-4 focus:outline-none hover:bg-gray-600 rounded text-lg">前の週</button>
                                    <button @click="nextWeek" class="ml-6 text-white bg-blue-500 border-0 py-2 px-4 focus:outline-none hover:bg-blue-600 rounded text-lg">次の週</button>
                                </div>
                                <div class="week-grid">
                                    <div class="day" v-for="(day, index) in weekDays" :key="index">
                                        <h4>{{ formatDate(day) }}</h4>
                                        <div class="slots">
                                            <p v-for="(item, itemIndex) in weekSchedules[formatDate(day)]" :key="itemIndex">
                                                {{ getSubjectNameById(item.schedule) || '　' }}
                                            </p>
                                        </div>
                                        <div>

                                        </div>
                                        <input type="checkbox" v-model="weekSchedules[formatDate(day)].allChecked" :id="'all_check_' + index" name="subject_id_all_check" disabled value="1">
                                        <label :for="'all_check_' + index" class="mx-3 my-3">全ての時間割</label>
                                    </div>
                                </div>
                                <div class="my-5 text-center">
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
    </AuthenticatedChildLayout>
</template>
