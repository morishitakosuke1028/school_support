<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const showItem = ref({
    logo: false,
    text1: false,
    text2: false,
    image: false
});

onMounted(() => {
    setTimeout(() => showItem.value.logo = true, 100);
    setTimeout(() => showItem.value.text1 = true, 600);
    setTimeout(() => showItem.value.text2 = true, 1100);
    setTimeout(() => showItem.value.image = true, 1600);
});
</script>
<template>
    <Head title="すくサポ　公式" />

    <div class="flex flex-col md:flex-row w-full min-h-screen">
        <div class="md:w-1/2 w-full flex justify-center items-center">
            <img src="images/kv_pc.jpg" class="md:h-full h-auto md:w-full object-cover fade-in" alt="">
        </div>
        <div class="flex w-full md:w-1/2 justify-center">
            <div>
                <h1 :class="showItem.logo ? 'slide-in' : 'hidden-start'" class="mx-auto md:ml-24 mb-12">
                    <img src="images/logo.png" alt="">
                </h1>
                <p :class="showItem.text1 ? 'slide-in' : 'hidden-start'" class="text-center bg-gray-200" style="font-size: 2em; color: cornflowerblue;">
                    小学校の<span class="font-bold" style="font-size: 1.5em; color: #00bfff;">当たり前</span>を
                </p>
                <p :class="showItem.text2 ? 'slide-in' : 'hidden-start'" class="text-center bg-gray-200 px-3" style="font-size: 2em; color: cornflowerblue;">
                    <span class="font-bold" style="font-size: 1.5em; color: #00bfff;">変える</span>サポートシステム
                </p>
                <div :class="showItem.image ? 'slide-in' : 'hidden-start'" class="text-center mt-10">
                    <img src="images/kv_sub.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto">
        <main class="w-full my-10">
            <section id="features" class="my-10">
                <h2 class="text-2xl font-bold text-center">主な機能</h2>
                <!-- 機能一覧の内容 -->
            </section>
            <section id="testimonials" class="my-10">
                <h2 class="text-2xl font-bold text-center">ログイン</h2>
                <div class="flex justify-center items-center h-screen">
                    <div class="bg-center bg-cover m-4">
                        <img src="images/admin_login.webp" alt="">
                    </div>
                    <Link as="button" class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg ml-5" :href="route('login')">
                        管理側ログイン
                    </Link>
                    <div class="bg-center bg-cover m-4">
                        <img src="images/child_login.webp" alt="">
                    </div>
                    <Link as="button" class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg ml-5" :href="route('child.login')">
                        生徒（保護者）ログイン
                    </Link>
                </div>
            </section>
            <section id="faq" class="my-10">
            <h2 class="text-2xl font-bold text-center">よくあるご質問</h2>
            <!-- FAQの内容 -->
            </section>
        </main>
    </div>
    <footer class="text-center py-5 bg-blue-200">
        © 2024 すくサポ. All rights reserved.
    </footer>
</template>
<style>
    .fade-in {
        animation: fadeInAnimation 2s ease-in forwards;
    }

    @keyframes fadeInAnimation {
        from {
        opacity: 0;
        }
        to {
        opacity: 1;
        }
    }

    .hidden-start {
        opacity: 0;
        transform: translateX(-50px);
    }

    .slide-in {
        opacity: 0;
        transform: translateX(-50px);
        animation: slideInAnimation 0.5s forwards;
    }

    @keyframes slideInAnimation {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>
