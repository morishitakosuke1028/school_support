<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive, ref, watchEffect, nextTick, watch } from 'vue'

const props = defineProps({
    gradeClassHistory: Object,
    children: Object,
    users: Object,
})

const form = reactive({
    id: props.gradeClassHistory.id,
    user_id: props.gradeClassHistory.user_id,
    child_id: props.gradeClassHistory.child_id,
})

const selectedGradeClassChildren = ref([]);
const selectedChildren = ref([]);
const tempSelectedChildren = ref([]);

const moveToRight = () => {
    console.log('moveToRight ボタンが押されました');
    console.log('移動前 selectedGradeClassChildren:', selectedGradeClassChildren.value);

    if (selectedChildren.value.length > 0) {
        selectedGradeClassChildren.value = [
            ...selectedGradeClassChildren.value,
            ...selectedChildren.value.map(childId => ({ id: childId }))
        ];

        // 選択された子供を非表示にする
        selectedChildren.value.forEach(childId => {
            const childIndex = props.children.findIndex(child => child.id === childId);
            if (childIndex !== -1) {
                props.children[childIndex].hidden = true;
            }
        });

        selectedChildren.value = [];
    }

    console.log('移動後 selectedGradeClassChildren:', selectedGradeClassChildren.value);
}

const moveToLeft = () => {
  // 右から左に移動するときの処理
  if (selectedGradeClassChildren.value.length > 0) {
    tempSelectedChildren.value = selectedGradeClassChildren.value.map(child => child.id);
    selectedGradeClassChildren.value = [];
  }
}

const childInChildren = (childId) => {
  return props.children.some(child => child.id === childId);
};

const getChildName = (childId) => {
  const matchingChild = props.children.find(child => child.id === childId);
  return matchingChild ? matchingChild.name : 'No Name';
};


// watchEffect(() => {
//   console.log('selectedGradeClassChildren が変更されました', selectedGradeClassChildren.value);
//   nextTick(() => {
//     console.log('DOM が更新されました');
//   });
// });


const updateGradeClassHistory = id => {
    form.child_id = selectedChildren.value;
    router.put(route('gradeClassHistories.update', { gradeClassHistory: form.id }), form)
}
const deleteGradeClassHistory = id => {
    router.delete(route('gradeClassHistories.destroy', { gradeClassHistory: id }), {
        onBefore: () => confirm('本当に削除しますか？')
    })
}
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
                                                        <label class="leading-7 text-sm text-gray-600">生徒名</label>
                                                        <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                        <div>
                                                            <select multiple v-model="selectedChildren" style="height: 20em; width: 12em;">
                                                                <option v-for="child in props.children" :key="child.id" :value="child.id">
                                                                    <span v-if="!child.hidden">{{ child.name }}</span>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="margin-top: 8em;">
                                                    <input type="button" name="right" value="≫" style="font-size: 2em;" @click="moveToRight" />
                                                    <br />
                                                    <br />
                                                    <input type="button" name="left" value="≪" style="font-size: 2em;" @click="moveToLeft" />
                                                </div>
                                                <div class="p-2">
                                                    <div class="relative">
                                                        <label class="leading-7 text-sm text-gray-600">生徒名</label>
                                                        <span class="font-medium text-sm text-red-700">　(必須)</span>
                                                        <div>
                                                            <select multiple style="height: 20em; width: 12em;" v-model="selectedGradeClassChildren">
                                                                <option v-for="child in selectedGradeClassChildren" :key="child.id" :value="child.id">
                                                                    {{ child && child.id && childInChildren(child.id) ? getChildName(child.id) : '　' }}
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
