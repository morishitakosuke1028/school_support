<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

defineProps({
    errors: Object
})

const { props } = usePage();

const form = ref({
    grade_class_id: '',
    start_datetime: null,
    end_datetime: null,
    title: null,
    place: null,
    personal_effect: null,
    content: null
})

onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    form.value.date = params.get('date');
    form.value.grade_class_id = params.get('gradeClassId');
});

const combineDateTime = (date, time) => {
    return time ? `${date} ${time}` : null;
};

const storeEvent = () => {
    const startDateTime = combineDateTime(form.value.date, form.value.start_datetime);
    const endDateTime = combineDateTime(form.value.date, form.value.end_datetime);

    router.post('/events', {
        ...form.value,
        start_datetime: startDateTime,
        end_datetime: endDateTime,
    });
}
</script>
<template>
    <Head title="行事作成" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                行事作成
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="storeEvent">
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="start_datetime" class="leading-7 text-sm text-gray-600">開始日時</label>
                                                    <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                    <input type="time" id="start_datetime" name="start_datetime" v-model="form.start_datetime" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <div v-if="errors.start_datetime" class="mt-3 text-red-500 text-xs">{{ errors.start_datetime }}</div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="end_datetime" class="leading-7 text-sm text-gray-600">終了日時</label>
                                                    <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                    <input type="time" id="end_datetime" name="end_datetime" v-model="form.end_datetime" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <div v-if="errors.end_datetime" class="mt-3 text-red-500 text-xs">{{ errors.end_datetime }}</div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="title" class="leading-7 text-sm text-gray-600">タイトル</label>
                                                    <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                    <input type="text" id="title" name="title" v-model="form.title" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <div v-if="errors.title" class="mt-3 text-red-500 text-xs">{{ errors.title }}</div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="place" class="leading-7 text-sm text-gray-600">開催場所</label>
                                                    <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                    <input type="text" id="place" name="place" v-model="form.place" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <div v-if="errors.place" class="mt-3 text-red-500 text-xs">{{ errors.place }}</div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="personal_effect" class="leading-7 text-sm text-gray-600">持ち物</label>
                                                    <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                    <input type="text" id="personal_effect" name="personal_effect" v-model="form.personal_effect" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <div v-if="errors.personal_effect" class="mt-3 text-red-500 text-xs">{{ errors.personal_effect }}</div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="content" class="leading-7 text-sm text-gray-600">行事内容</label>
                                                    <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                    <textarea id="content" name="content" v-model="form.content" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"></textarea>
                                                </div>
                                                <div v-if="errors.content" class="mt-3 text-red-500 text-xs">{{ errors.content }}</div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録</button>
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
    </AuthenticatedLayout>
</template>
