<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive, ref, computed, watch, onMounted, nextTick } from 'vue'

const props = defineProps({
    gradeClassHistory: Object,
    gradeClassHistories: Array,
    children: Array,
    users: Object,
    gradeClasses: Array,
    childrenNotInGradeClass: Object,
    childrenInGradeClass: Object,
})

// 1セット目のセレクトボックス用
const form = reactive({
    id: props.gradeClassHistory.id,
    user_id: props.gradeClassHistory.user_id,
    grade_class_id: props.gradeClassHistory.grade_class_id,
    child_id: props.gradeClassHistory.child_id,
})
// 2セット目のセレクトボックス用
const form2 = reactive({
    id: props.gradeClassHistory.id,
    user_id: props.gradeClassHistory.user_id,
    grade_class_id: props.gradeClassHistory.grade_class_id,
    child_id: props.gradeClassHistory.child_id,
})

// 1セット目のセレクトボックス用
const selectedClassId = ref(null);
const selectedChildren = ref([]);
// const selectedChildren = ref(props.gradeClassHistory.child_id);

// 2セット目のセレクトボックス用
const selectedClassId2 = ref(null);
const selectedChildren2 = ref([]);
// const selectedChildren2 = ref(props.gradeClassHistory.child_id);

const updateGradeClassHistory = () => {
    form.child_id = selectedChildren.value;
    router.put(route('gradeClassHistories.update', { gradeClassHistory: form.id }), form)
}

const deleteGradeClassHistory = () => {
    router.delete(route('gradeClassHistories.destroy', { gradeClassHistory: form.id }), {
        onBefore: () => confirm('本当に削除しますか？')
    })
}

// 1セット目のセレクトボックス用
const getChildName = (childId) => {
    const matchingChild = props.children.find((child) => child.id === childId);
    if (matchingChild) {
        return matchingChild.name;
    }
};

const getChildrenNotInClass = computed(() => {
    return props.childrenNotInGradeClass;
});

const handleChangeClass = () => {
    if (props.gradeClassHistories) {
        const gradeClassHistoriesArray = Array.isArray(props.gradeClassHistories)
            ? props.gradeClassHistories
            : [props.gradeClassHistories];

        const selectedGradeClassHistories = gradeClassHistoriesArray.filter(
            (history) => history.grade_class_id === selectedClassId.value
        );

        selectedChildren.value = selectedGradeClassHistories.map((history) => history.child_id);
    }
};

// 2セット目のセレクトボックス用
const getChildName2 = (childId) => {
    const matchingChild = props.children.find((child) => child.id === childId);
    return matchingChild ? matchingChild.name : '';
};

const handleChangeClass2 = () => {
    if (props.gradeClassHistories) {
        const gradeClassHistoriesArray = Array.isArray(props.gradeClassHistories)
            ? props.gradeClassHistories
            : [props.gradeClassHistories];

        const selectedGradeClassHistories = gradeClassHistoriesArray.filter(
            (history) => history.grade_class_id === selectedClassId2.value
        );

        selectedChildren2.value = selectedGradeClassHistories.map((history) => history.child_id);
    }
};

const localData = reactive({
    childrenNotInGradeClass: props.childrenNotInGradeClass || [] // 初期値を設定
});

const moveToRight = () => {
    const selectedForMoving = [...selectedChildren.value];
    selectedChildren2.value = [...selectedChildren2.value, ...selectedForMoving];

    // 選択された生徒を隠す
    selectedForMoving.forEach(childId => {
        const child = localData.childrenNotInGradeClass.find(c => c.id === childId);
        if (child) {
            child.hidden = true;
        }
    });

    nextTick(() => {
        console.log('DOMが更新された後の状態:', selectedChildren.value, selectedChildren2.value);
    });
};

const moveToLeft = () => {
    const selectedChildrenArray = Array.isArray(selectedChildren.value) ? selectedChildren.value : [selectedChildren.value];
    const selectedChildren2Array = Array.isArray(selectedChildren2.value) ? selectedChildren2.value : [selectedChildren2.value];

    selectedChildren2.value = selectedChildren2Array.filter((childId) => !selectedChildrenArray.includes(childId));
};
</script>

<template>
    <Head title="学年クラス替え" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                学年クラス替え
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font relative flex-auto">

                            <form @submit.prevent="updateGradeClassHistory(form.id)">
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div>
                                            <div class="flex justify-between mt-8">
                                                <div class="p-2">
                                                    <div class="p-2 w-full">
                                                        <div class="relative">
                                                            <label class="leading-7 text-sm text-gray-600">担任</label>
                                                            <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                            <div>
                                                                <select v-model="form.user_id">
                                                                    <option v-for="user in props.users" :key="user.id" :value="user.id">{{ user.name }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="relative">
                                                        <label for="classSelector">クラス</label><br>
                                                        <select id="classSelector" v-model="selectedClassId" @change="handleChangeClass">
                                                            <option :value="null">所属なし生徒</option>
                                                            <option v-for="gradeClass in gradeClasses" :key="gradeClass.id" :value="gradeClass.id">
                                                                {{ gradeClass.grade_name }}{{ gradeClass.class_name }}
                                                            </option>
                                                        </select>
                                                        <br>
                                                        <br>
                                                        <label class="leading-7 text-sm text-gray-600">生徒名</label>
                                                        <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                        <div v-if="selectedClassId === null">
                                                            <!-- 学年クラスに所属していない生徒一覧 -->
                                                            <select multiple style="height: 20em; width: 12em;" id="classSelector" v-model="selectedChildren">
                                                                <option v-for="child in localData.childrenNotInGradeClass" :key="child.id" :value="child.id">
                                                                    <span v-if="!child.hidden">
                                                                        {{ child.name }}
                                                                    </span>
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div v-else>
                                                            <!-- 選択された学年クラス毎の生徒一覧 -->
                                                            <select multiple style="height: 20em; width: 12em;" id="classSelector" v-model="selectedChildren">
                                                                <option v-for="childId in selectedChildren" :value="childId">
                                                                    {{ getChildName(childId) }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="margin-top: 15em;" v-if="selectedClassId2 !== null">
                                                    <input type="button" name="right" value="≫" style="font-size: 2em;" @click="moveToRight" />
                                                    <br />
                                                    <br />
                                                    <input type="button" name="left" value="≪" style="font-size: 2em;" @click="moveToLeft" />
                                                </div>
                                                <div class="p-2">
                                                    <div class="p-2 w-full">
                                                        <div class="relative">
                                                            <label class="leading-7 text-sm text-gray-600">担任</label>
                                                            <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                            <div>
                                                                <select v-model="form2.user_id">
                                                                    <option v-for="user in props.users" :key="user.id" :value="user.id">{{ user.name }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="relative">
                                                        <label for="classSelector">クラス</label><br>
                                                        <select id="classSelector" v-model="selectedClassId2" @change="handleChangeClass2">
                                                            <option :value="null">---</option>
                                                            <option v-for="gradeClass in gradeClasses" :key="gradeClass.id" :value="gradeClass.id">
                                                                {{ gradeClass.grade_name }}{{ gradeClass.class_name }}
                                                            </option>
                                                        </select>
                                                        <br>
                                                        <br>
                                                        <label class="leading-7 text-sm text-gray-600">生徒名</label>
                                                        <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                        <div v-if="selectedClassId2 !== null">
                                                            <!-- 選択された学年クラス毎の生徒一覧 -->
                                                            <select multiple style="height: 20em; width: 12em;" id="classSelector" v-model="selectedChildren2">
                                                                <option v-for="childId in selectedChildren2" :value="childId">
                                                                    {{ getChildName2(childId) }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full text-center">
                                                <button class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg mr-5">更新</button>
                                                <Link as="button" class="text-white bg-gray-500 border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg ml-5" :href="route('gradeClassHistories.index')">
                                                    戻る
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="p-2 w-full">
                                <button @click="deleteGradeClassHistory(gradeClassHistory.id)" class="flex mx-auto text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">削除する</button>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
