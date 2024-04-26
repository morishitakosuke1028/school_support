<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';
import draggable from 'vuedraggable';
import { startOfWeek, addWeeks, format, eachDayOfInterval } from 'date-fns';

const props = defineProps({
    subjects: Array
});

const localSubjects = ref([...props.subjects]);

const currentDate = ref(new Date());  // 現在の日付を保持
const displayedWeek = ref(startOfWeek(currentDate.value, { weekStartsOn: 1 }));  // 週の開始を月曜日に設定

const weekDays = computed(() => {
  return eachDayOfInterval({
    start: displayedWeek.value,
    end: addWeeks(displayedWeek.value, 1)
  });
});

// 次の週へ移動
function nextWeek() {
  displayedWeek.value = addWeeks(displayedWeek.value, 1);
}

// 前の週へ移動
function prevWeek() {
  displayedWeek.value = addWeeks(displayedWeek.value, -1);
}

// 日付の表示形式を整形
function formatDate(date) {
  return format(date, 'yyyy-MM-dd');
}

const submitForm = async () => {

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

button {
  margin: 5px;
  padding: 10px;
  background-color: #007BFF;
  color: white;
  border: none;
  cursor: pointer;
}
button:hover {
  background-color: #0056b3;
}
.calendar .week-grid {
  display: flex;
  justify-content: space-between;
  padding: 10px;
}

.calendar .day {
  flex: 1;
  padding: 10px;
  background: #eee;
  border: 1px solid #ddd;
  text-align: center;
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
                                <draggable v-model="localSubjects" item-key="id" tag="ul">
                                    <template v-slot:item="{ element }">
                                    <li :key="element.id" class="drag-item">
                                        {{ element.name }}
                                    </li>
                                    </template>
                                </draggable>

                                <div>
                                    <h3>週の表示：{{ formatDate(displayedWeek) }} - {{ formatDate(addWeeks(displayedWeek, 1)) }}</h3>
                                    <button @click="prevWeek">前の週</button>
                                    <button @click="nextWeek">次の週</button>
                                    <div class="week-grid">
                                        <div class="day" v-for="(day, index) in weekDays" :key="index">
                                        {{ formatDate(day) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="my-5 text-center">
                                    <button class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg mr-5">登録</button>
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
