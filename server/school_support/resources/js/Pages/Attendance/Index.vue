<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import { ref, onMounted } from 'vue';
import SearchForm from '@/Components/SearchForm.vue';

const props = defineProps({
    gradeClasses: Array,
});
</script>
<template>
    <Head title="登下校一覧" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                登下校一覧
            </h2>
        </template>

        <FlashMessage />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font">
                            <SearchForm v-if="props.gradeClasses" :gradeClasses="props.gradeClasses" />
                            <FlashMessage />
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
