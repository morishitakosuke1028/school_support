<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import { toRefs, reactive, onMounted } from 'vue';
import SearchForm from '@/Components/SearchForm.vue';

</script>
<template>
    <Head title="行事一覧" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                行事一覧
            </h2>
        </template>
    </AuthenticatedLayout>
</template>
