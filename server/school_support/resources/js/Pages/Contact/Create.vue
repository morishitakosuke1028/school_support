<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const { child, currentUser } = usePage().props;

const form = ref({
    user_id: currentUser,
    child_id: child.id,
    content: null
})

const storeContact = () => {
    router.post('/contacts', form.value);
};

</script>
<template>
    <Head title="連絡" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                連絡
            </h2>
        </template>

        <section class="text-gray-600 body-font">
            <div class="container mx-auto flex flex-col px-5 py-12 justify-center items-center">
                <div class="w-full md:w-2/3 flex flex-col items-center text-center">
                    <h3 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">{{ child ? `${child.name}さんの連絡帳` : '連絡帳' }}</h3>
                </div>
            </div>
        </section>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="storeContact">
                                <input type="hidden" id="child_id" name="child_id" v-model="child.id">
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="content" class="leading-7 text-sm text-gray-600"></label>
                                                    <textarea id="content" name="content" v-model="form.content" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"></textarea>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">送信</button>
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
