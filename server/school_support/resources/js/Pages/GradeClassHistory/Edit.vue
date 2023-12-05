<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive, ref, computed } from 'vue'

const props = defineProps({
    gradeClassHistory: Object,
    children: Array,
    users: Object,
    gradeClasses: Array,
    childrenNotInGradeClass: Object,
    childrenInGradeClass: Object,
})

const form = reactive({
    id: props.gradeClassHistory.id,
    user_id: props.gradeClassHistory.user_id,
    child_id: props.gradeClassHistory.child_id,
})

const selectedChildren = ref(form.child_id); // 初期値を設定

const updateGradeClassHistory = () => {
    form.child_id = selectedChildren.value;
    router.put(route('gradeClassHistories.update', { gradeClassHistory: form.id }), form)
}

const deleteGradeClassHistory = () => {
    router.delete(route('gradeClassHistories.destroy', { gradeClassHistory: form.id }), {
        onBefore: () => confirm('本当に削除しますか？')
    })
}

const getChildName = (childId) => {
    const matchingChild = props.children.find((child) => child.id === childId);
    return matchingChild ? matchingChild.name : 'No Name';
};

const getFilteredHistories = computed(() => {
    if (selectedClassId.value === null) {
        // 所属なし生徒を選択した場合は全ての履歴を返す
        return [props.gradeClassHistory]; // オブジェクトを配列に変換
    } else {
        // 特定のクラスに所属する生徒の履歴を返す
        const childHistories = props.gradeClassHistory.child_id || []; // 配列がない場合は空配列をセット
        console.log(childHistories);
        return childHistories.filter((history) => history.grade_class_id === selectedClassId.value);
    }
});

const getChildrenNotInClass = computed(() => {
    // 所属なし生徒の取得
    return props.children.filter((child) => {
        return !props.gradeClassHistory.some((history) => history.child_id.includes(child.id));
    });
});

const selectedClassId = ref(null); // selectedClassId を追加



const handleChangeClass = () => {
    // クラスが変更されたときに何か処理が必要な場合はここに追加
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
                                            <div class="flex justify-between mt-8">
                                                <div class="p-2">
                                                    <div class="relative">
                                                        <label for="classSelector">クラス</label>
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
                                                            <select multiple style="height: 20em; width: 12em;" id="classSelector">
                                                                <option v-for="child in props.childrenNotInGradeClass" :key="child.id" :value="child.id">
                                                                    {{ child.name }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div v-else>
                                                            <select multiple style="height: 20em; width: 12em;" id="classSelector">
                                                                <template v-for="history in getFilteredHistories">
                                                                    <template v-for="(childId, index) in history.child_id" :key="index">
                                                                    <option :value="childId">{{ getChildName(childId) }}</option>
                                                                    </template>
                                                                </template>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="margin-top: 8em;">
                                                    <!-- <input type="button" name="right" value="≫" style="font-size: 2em;" @click="moveToRight" />
                                                    <br />
                                                    <br />
                                                    <input type="button" name="left" value="≪" style="font-size: 2em;" @click="moveToLeft" /> -->
                                                </div>
                                                <div class="p-2">
                                                    <div class="relative">
                                                        <label class="leading-7 text-sm text-gray-600">生徒名</label>
                                                        <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                        <div>
                                                            <!-- <select multiple style="height: 20em; width: 12em;" v-model="selectedGradeClassChildren">
                                                                <option v-for="child in props.children" :key="child.id" :value="child.id">
                                                                    <span v-if="selectedGradeClassChildren.includes(child.id)">
                                                                        {{ child && child.id ? getChildName(child.id) : '　' }}
                                                                    </span>
                                                                </option>
                                                            </select> -->
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
