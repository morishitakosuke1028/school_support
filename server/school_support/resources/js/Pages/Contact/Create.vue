<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const { child, currentUser, contacts, currentUserName, currentUserRole } = usePage().props;

const form = ref({
    user_id: currentUser,
    child_id: child.id,
    sender: currentUserName,
    content: null
})

const storeContact = () => {
    router.post('/contacts', form.value);
};

const deleteContact = id => {
    router.delete(route('contacts.destroy', { contact: id }), {
        onBefore: () => confirm('本当に削除しますか？')
    })
}
</script>
<style>
.contact-note {
  width: 100%;
  max-width: 600px;
  margin: auto;
  border-collapse: collapse;
}

.contact-note table {
  width: 100%;
  writing-mode: vertical-rl;
}

.contact-note th, .contact-note td {
  border: 1px solid ;
  padding: 5px;
}

.contact-note thead th {
  background-color: #00BFFF;
  color: white;
}

.contact-note tbody td {
  text-align: center;
  vertical-align: top;
}

.contact-note td:last-child {
  background-color: white;
}

.vertical-text {
  writing-mode: vertical-rl;
  text-orientation: upright;
}

.contact-note th, .contact-note td {
  padding: 8px;
  border: 1px solid #00BFFF;
  text-align: center;
}

.contact-note tbody td {
  vertical-align: middle;
}
</style>
<template>
    <Head title="連絡" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                連絡
            </h2>
        </template>

        <section class="bg-white">
            <div class="contact-note">
                <table>
                    <thead>
                    <tr>
                        <th>月</th>
                        <th>日</th>
                        <th>内容</th>
                        <th>記入欄</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(contact, index) in contacts" :key="contact.id">
                            <td>
                                <div class="vertical-text">{{ new Date(contact.created_at).getMonth() + 1 }}</div>
                            </td>
                            <td>
                                <div class="vertical-text">{{ new Date(contact.created_at).getDate() }}</div>
                            </td>
                            <td>
                                <div class="content-text">{{ contact.content }}</div>
                            </td>
                            <td>
                                <div class="vertical-text">{{ contact.sender }}</div>
                            </td>
                            <td v-if="currentUserRole">
                                <button @click="deleteContact(contact.id)" class="text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">除削</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="storeContact">
                                <input type="hidden" id="sender" name="sender" v-model="currentUserName">
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
