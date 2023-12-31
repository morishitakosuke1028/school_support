<script setup>
import { usePage, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const { props } = usePage();

const gradeClasses = ref(props.gradeClasses || []);
const selectedGradeNames = ref([]);
const selectedClassNames = ref([]);
const filtersFromBackend = props.filters || {};

// 検索フィルターの状態
const searchFilters = ref({
    gradeName: filtersFromBackend.gradeName || '',
    className: filtersFromBackend.className || '',
    childName: filtersFromBackend.childName || '',
    childKana: filtersFromBackend.childKana || '',
    childDaily: filtersFromBackend.childDaily || new Date().toISOString().slice(0, 10)
});

const gradeNames = computed(() => {
    return [...new Set(gradeClasses.value.map(gc => gc?.grade_name).filter(gn => gn))];
});

const classNames = computed(() => {
    return [...new Set(gradeClasses.value.map(gc => gc?.class_name).filter(cn => cn))];
});

const submitSearch = () => {
    const searchQuery = {
        ...searchFilters.value,
        gradeNames: selectedGradeNames.value.join(','),
        classNames: selectedClassNames.value.join(',')
    };
    router.get(route('attendance.index'), searchQuery);
};
</script>

<template>
    <div class="pl-4 my-6 w-full mx-auto">
        <form @submit.prevent="submitSearch" class="space-x-4">
            <div class="my-5 mx-4">
                <label for="childName" class="text-gray-700">生徒名：　</label>
                <input type="text" name="childName" v-model="searchFilters.childName" placeholder="山田 太郎" class="p-2 border border-gray-300 rounded">
            </div>

            <div class="my-5">
                <label for="childKana" class="text-gray-700">かな：　</label>
                <input type="text" name="childKana" v-model="searchFilters.childKana" placeholder="やまだ たろう" class="p-2 border border-gray-300 rounded">
            </div>

            <div class="flex my-5">
                <span class="mr-5">学年：</span>
                <div v-for="gradeName in gradeNames" :key="gradeName">
                    <label class="mr-5">
                        <input type="checkbox" :value="gradeName" v-model="selectedGradeNames">
                        {{ gradeName }}
                    </label>
                </div>
            </div>

            <div class="flex my-5">
                <span class="mr-5">クラス：</span>
                <div v-for="className in classNames" :key="className">
                    <label class="mr-5">
                        <input type="checkbox" :value="className" v-model="selectedClassNames">
                        {{ className }}
                    </label>
                </div>
            </div>

            <div class="my-5">
                <label for="childDaily" class="text-gray-700">日付：　</label>
                <input type="date" name="childDaily" v-model="searchFilters.childDaily" class="p-2 border border-gray-300 rounded">
            </div>

            <div class="text-center">
                <button type="submit" class="px-6 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">検索</button>
            </div>
        </form>
    </div>
</template>
