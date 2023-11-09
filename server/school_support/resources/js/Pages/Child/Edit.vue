<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive } from 'vue';

const props = defineProps({
    child: Object
})
const form = reactive({
    id: props.child.id,
    name: props.child.name,
    kana: props.child.kana,
    gender: props.child.gender,
    zip: props.child.zip,
    address: props.child.address,
    birthday: props.child.birthday,
    admission_date: props.child.admission_date,
    email: props.child.email,
    tel: props.child.tel,
    pin_code: props.child.pin_code,
    session_id: props.child.session_id,
    movein_date: props.child.movein_date,
    graduation_date: props.child.graduation_date,
})
const updateChild = id => {
    router.put(route('child.update', { child: id }), form)
}
</script>

<template>
    <Head title="生徒編集" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                生徒編集
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="updateChild(form.id)">
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="name" class="leading-7 text-sm text-gray-600">生徒名</label>
                                                    <input type="text" id="name" name="name" v-model="form.name" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="kana" class="leading-7 text-sm text-gray-600">かな</label>
                                                    <input type="text" id="kana" name="kana" v-model="form.kana" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="gender" class="leading-7 text-sm text-gray-600 mr-4">性別</label><br>
                                                    <input type="radio" id="gender" name="role" v-model="form.gender" value="1" />
                                                    <label class="ml-2 mr-4">男</label>
                                                    <input type="radio" id="gender_women" name="role" v-model="form.gender" value="2" />
                                                    <label class="ml-2 mr-4">女</label>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="zip" class="leading-7 text-sm text-gray-600">郵便番号</label>
                                                    <input type="text" id="zip" name="zip" v-model="form.zip" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="address" class="leading-7 text-sm text-gray-600">住所</label>
                                                    <input type="text" id="address" name="address" v-model="form.address" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="birthday" class="leading-7 text-sm text-gray-600">生年月日</label>
                                                    <input type="date" id="birthday" name="birthday" v-model="form.birthday" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="admission_date" class="leading-7 text-sm text-gray-600">入学日</label>
                                                    <input type="date" id="admission_date" name="admission_date" v-model="form.admission_date" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="email" class="leading-7 text-sm text-gray-600">保護者メールアドレス</label>
                                                    <input type="text" id="email" name="email" v-model="form.email" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="tel" class="leading-7 text-sm text-gray-600">電話番号</label>
                                                    <input type="text" id="tel" name="tel" v-model="form.tel" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="pin_code" class="leading-7 text-sm text-gray-600">簡易認証コード</label>
                                                    <input type="text" id="pin_code" name="pin_code" v-model="form.pin_code" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="session_id" class="leading-7 text-sm text-gray-600">認証 ID</label>
                                                    <input type="text" id="session_id" name="session_id" v-model="form.session_id" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="movein_date" class="leading-7 text-sm text-gray-600">転校日</label>
                                                    <input type="date" id="movein_date" name="movein_date" v-model="form.movein_date" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="graduation_date" class="leading-7 text-sm text-gray-600">卒業日</label>
                                                    <input type="date" id="graduation_date" name="graduation_date" v-model="form.graduation_date" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
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
