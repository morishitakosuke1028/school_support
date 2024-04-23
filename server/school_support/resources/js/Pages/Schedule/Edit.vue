<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
// import { VueDraggableNext } from 'vue-draggable-next'
// import draggable from 'vuedraggable';
import { Draggable } from 'vue-draggable-next';

const props = defineProps({
    subjects: Object,
});

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
                                <draggable v-model="props.subjects" item-key="id" class="drag-area" tag="ul">
                                    <template v-slot:item="{ element }">
                                        <li :key="element.id" class="drag-item">
                                            {{ element.name }}
                                        </li>
                                    </template>
                                </draggable>

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
