<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    events: Object,
    gradeClasses: Object,
    currentUserRole: Boolean,
});

const selectedYear = ref(new Date().getFullYear());
const selectedMonth = ref(new Date().getMonth() + 1);
const selectedClassId = ref('');

const years = computed(() => {
  const year = new Date().getFullYear();
  return Array.from({ length: 10 }, (_, i) => year - 5 + i);
});

const months = [
  '1月', '2月', '3月', '4月', '5月', '6月',
  '7月', '8月', '9月', '10月', '11月', '12月'
];

const days = ['日', '月', '火', '水', '木', '金', '土'];

function getDaysInMonth(year, month) {
  const date = new Date(year, month - 1, 1);
  const days = [];
  while (date.getMonth() === month - 1) {
    days.push(date.getDate());
    date.setDate(date.getDate() + 1);
  }
  return days;
}

function handleDayClick(day) {
    const dateString = `${selectedYear.value}-${selectedMonth.value}-${day}`;
    const path = `/events/create?date=${dateString}&gradeClassId=${selectedClassId.value}`;

    // ルーターを使用して指定のパスに遷移
    router.get(path);
}

const formatDate = (date) => {
  const d = new Date(date);
  const month = `${d.getMonth() + 1}`.padStart(2, '0'); // 月を2桁にフォーマット
  const day = `${d.getDate()}`.padStart(2, '0'); // 日を2桁にフォーマット
  return `${d.getFullYear()}${month}${day}`; // YYYYMMDD形式
};
</script>
<template>
    <Head title="行事一覧" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                行事一覧
            </h2>
        </template>

        <FlashMessage />
        <div class="container mx-auto p-4">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <select v-model="selectedYear" class="mr-2">
                        <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                    </select>
                    <select v-model="selectedMonth" class="mr-2">
                        <option v-for="(month, index) in months" :key="index" :value="index + 1">{{ month }}</option>
                    </select>
                    <select id="classSelect" v-model="selectedClassId">
                        <option disabled value="">クラスを選択してください</option>
                        <option v-for="(gradeClass, id) in gradeClasses" :key="id" :value="gradeClass.id">
                            {{ gradeClass.grade_name }}{{ gradeClass.class_name }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-7 gap-4 text-center">
                <div class="font-bold" v-for="day in days" :key="day">{{ day }}</div>
                <div v-for="day in getDaysInMonth(selectedYear, selectedMonth)" :key="day" class="py-8 bg-gray-100 rounded shadow cursor-pointer hover:bg-blue-200" @click="handleDayClick(day)">
                    {{ day }}
                    <div v-for="event in events">
                        <p style="background-color: aqua;" v-if="formatDate(event.start_datetime) == `${selectedYear}${String(selectedMonth).padStart(2, '0')}${String(day).padStart(2, '0')}`">{{ event.title }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
