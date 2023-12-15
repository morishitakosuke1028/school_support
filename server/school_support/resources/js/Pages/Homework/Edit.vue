<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { reactive, computed } from 'vue'

// const props = defineProps({
//     gradeClass: Object,
//     homework: Object
// })

const { props } = usePage();
const currentYear = new Date().getFullYear();
const currentMonth = new Date().getMonth();

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
    id: props.homework.id,
    grade_class_id: props.homework.grade_class_id,
    homework_day: props.homework.homework_day,
    reading: props.homework.reading,
    language_drill: props.homework.language_drill,
    arithmetic: props.homework.arithmetic,
    diary: props.homework.diary,
    ipad: props.homework.ipad,
    other: props.homework.other,
})

const updateGradeClass = id => {
    router.put(route('homeworks.update', { homework: id }), form)
}
// const deleteGradeClass = id => {
//     router.delete(route('gradeClasses.destroy', { gradeClass: id }), {
//         onBefore: () => confirm('本当に削除しますか？')
//     })
// }
</script>

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
                            <form @submit.prevent="submitHomework">
                                <div v-for="day in getDaysInMonth(currentYear, currentMonth)" :key="day.getDate()" class="day">
                                    <div>{{ day.getDate() }}</div>
                                    <label>
                                    <input type="checkbox" :name="'homework[' + day.getDate() + '][reading]'"> 音読
                                    </label>
                                    <label>
                                    <input type="checkbox" :name="'homework[' + day.getDate() + '][language_drill]'"> 漢字ドリル
                                    </label>
                                    <label>
                                    <input type="checkbox" :name="'homework[' + day.getDate() + '][arithmetic]'"> 算数プリント
                                    </label>
                                    <label>
                                    <input type="checkbox" :name="'homework[' + day.getDate() + '][diary]'"> 日記
                                    </label>
                                    <input type="text" :name="'homework[' + day.getDate() + '][ipad]'" placeholder="iPad">
                                    <input type="text" :name="'homework[' + day.getDate() + '][other]'" placeholder="その他">
                                    <input type="hidden" :name="'homework[' + day.getDate() + '][homework_day]'" :value="formatDate(day)">
                                    <input type="hidden" :name="'homework[' + day.getDate() + '][grade_class_id]'" :value="props.gradeClass.id">
                                </div>
                                <button type="submit">登録</button>
                            </form>
                            <!-- <div class="p-2 w-full">
                                <button @click="deleteGradeClass(gradeClass.id)" class="flex mx-auto text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">削除する</button>
                            </div> -->
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
