<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const showItem = ref({
    logo: false,
    text1: false,
    text2: false,
    image: false
});

const isQuestionVisible = ref(false);

function toggleQuestionVisibility() {
  isQuestionVisible.value = !isQuestionVisible.value;
}

onMounted(() => {
    setTimeout(() => showItem.value.logo = true, 100);
    setTimeout(() => showItem.value.text1 = true, 600);
    setTimeout(() => showItem.value.text2 = true, 1100);
    setTimeout(() => showItem.value.image = true, 1600);

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('slide-up');
                observer.unobserve(entry.target);
            }
        });
    }, {threshold: 0.4});

    document.querySelectorAll('.animatable').forEach(el => {
        observer.observe(el);
    });
});
</script>
<template>
    <Head title="すくサポ　公式" />

    <div class="flex flex-col md:flex-row w-full md:min-h-screen-md\:null">
        <div class="md:w-1/2 w-full flex justify-center items-center">
            <img src="images/kv_pc.jpg" class="md:h-full h-auto md:w-full object-cover fade-in" alt="">
        </div>
        <div class="flex w-full md:w-1/2 justify-center">
            <div>
                <h1 :class="showItem.logo ? 'slide-in' : 'hidden-start'" class="mx-auto md:ml-24 mb-12 logo-container">
                    <img src="images/logo.png" class="logo-image" alt="">
                </h1>
                <p :class="showItem.text1 ? 'slide-in' : 'hidden-start'" class="text-center bg-gray-200 px-1 text-top">
                    小学校の<span class="font-bold" style="font-size: 1.5em; color: #00bfff;">当たり前</span>を
                </p>
                <p :class="showItem.text2 ? 'slide-in' : 'hidden-start'" class="text-center bg-gray-200 px-3 text-bottom">
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
            <section id="features" class="animatable my-10">
                <h2 class="main-background text-2xl font-bold text-center">主な機能</h2>
                <!-- 機能一覧の内容 -->
            </section>
            <section id="testimonials" class="animatable my-10">
                <h2 class="login-background text-2xl font-bold text-center">ログイン</h2>
                <div class="md:flex justify-center items-center">
                    <div class="bg-center bg-cover m-4 relative">
                        <h3 class="overlay-text">学校職員の方はこちら</h3>
                        <img src="images/admin-login.jpg" class="admin-login-image" alt="">
                        <Link as="button" class="link-button text-white bg-blue-300 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg" :href="route('login')">
                            ログイン
                        </Link>
                    </div>
                    <div class="bg-center bg-cover m-4 relative">
                        <h3 class="overlay-text">保護者の方はこちら</h3>
                        <img src="images/child-login.jpg" class="child-login-image" alt="">
                        <Link as="button" class="link-button text-white bg-blue-300 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg" :href="route('child.login')">
                            ログイン
                        </Link>
                    </div>
                </div>
            </section>
            <section id="faq" class="animatable my-10">
                <h2 class="question-background text-2xl font-bold text-center">よくあるご質問</h2>
                <div class="text-center">
                    <p class="flex justify-between md:w-1/2 mx-auto my-4 px-2 py-2 bg-cyan-100 rounded border border-cyan-100">
                        <span class="pr-12">導入前のご質問</span>
                        <svg @click="toggleQuestionVisibility" width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="12" y1="2" x2="12" y2="22" stroke="black" stroke-width="2"/>
                            <line v-if="!isQuestionVisible" x1="2" y1="12" x2="22" y2="12" stroke="black" stroke-width="2"/>
                        </svg>
                    </p>
                    <div v-if="isQuestionVisible" class="md:w-1/2 mx-auto px-2 py- bg-cyan-100 rounded border border-cyan-100">
                        <p class="pb-3"><span class="text-bold text-xl text-blue-500">Q.</span>無料お試し期間はありますか？</p>
                        <p class="text-gray-500">
                            はい、最大で2ヶ月間無料でお試しいただけます。気にいっていただけましたらそのまま本契約後、データを引き継いでご利用いただくことも可能です（一部機能の制限があります）。詳しくは導入の流れをご確認ください。
                        </p>
                    </div>
                    <p class="flex justify-between md:w-1/2 mx-auto my-4 px-2 py-2 bg-cyan-100 rounded border border-cyan-100 text-center">
                        <span class="pr-12">運用関連のご質問</span>
                        <svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="12" y1="2" x2="12" y2="22" stroke="black" stroke-width="2"/>
                            <line x1="å2" y1="12" x2="22" y2="12" stroke="black" stroke-width="2"/>
                        </svg>
                    </p>
                    <p class="flex justify-between md:w-1/2 mx-auto my-4 px-2 py-2 bg-cyan-100 rounded border border-cyan-100 text-center">
                        <span class="pr-12">サポート関連のご質問</span>
                        <svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="12" y1="2" x2="12" y2="22" stroke="black" stroke-width="2"/>
                            <line x1="å2" y1="12" x2="22" y2="12" stroke="black" stroke-width="2"/>
                        </svg>
                    </p>
                    <p class="flex justify-between md:w-1/2 mx-auto my-4 px-2 py-2 bg-cyan-100 rounded border border-cyan-100 text-center">
                        <span class="pr-12">保護者関連のご質問</span>
                        <svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="12" y1="2" x2="12" y2="22" stroke="black" stroke-width="2"/>
                            <line x1="å2" y1="12" x2="22" y2="12" stroke="black" stroke-width="2"/>
                        </svg>
                    </p>
                </div>
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
    .text-top {
        font-size: 2em;
        color: cornflowerblue;
    }
    .text-bottom {
        font-size: 2em;
        color: cornflowerblue;
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
    .animatable {
        opacity: 0;
        transform: translateY(20px);
        visibility: hidden;
    }
    .slide-up {
        opacity: 1;
        transform: translateY(0);
        visibility: visible;
        animation: slideUpAnimation 1s forwards;
    }
    @keyframes slideUpAnimation {
        0% {
            opacity: 0;
            transform: translateY(20px);
            visibility: visible;
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .main-background {
        position: relative;
        overflow: hidden;
        padding: 1.5em 0;
    }
    .main-background::before {
        content: 'MAIN';
        position: absolute;
        top: 35%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 2em;
        color: rgba(240, 248, 255, 1);
        z-index: -1;
    }
    .login-background {
        position: relative;
        overflow: hidden;
        padding: 1.5em 0;
    }
    .login-background::before {
        content: 'LOGIN';
        position: absolute;
        top: 35%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 2em;
        color: rgba(240, 248, 255, 1);
        z-index: -1;
    }
    .admin-login-image {
        width: 600px;
        height: 400px;
    }
    .child-login-image {
        width: 600px;
        height: 400px;
    }
    .overlay-text {
        position: absolute;
        top: 40px;
        left: 50%;
        transform: translateX(-50%);
        padding-bottom: 10px;
        color: cornflowerblue;
        border-bottom: 3px dashed #4169e1;
        font-weight: bold;
        font-size: 1.5em;
    }
    .link-button {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
    }
    .relative {
        position: relative;
    }
    .question-background {
        position: relative;
        overflow: hidden;
        padding: 1.5em 0;
    }
    .question-background::before {
        content: 'FAQ';
        position: absolute;
        top: 35%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 2em;
        color: rgba(240, 248, 255, 1);
        z-index: -1;
    }

    @media only screen and (max-width: 960px) {
        .fade-in {
            animation: fadeInAnimation 2s ease-in forwards;
            height: 600px;
        }
        .logo-image {
            width: 50%;
        }
        .text-top {
            font-size: 1.8em;
            color: cornflowerblue;
        }
        .text-bottom {
            font-size: 1.8em;
            color: cornflowerblue;
        }
        .overlay-text {
            position: absolute;
            top: 40px;
            left: 50%;
            transform: translateX(-50%);
            padding-bottom: 10px;
            color: cornflowerblue;
            border-bottom: 3px dashed #4169e1;
            font-weight: bold;
            font-size: 1em;
        }
    }
    @media only screen and (max-width: 520px) {
        .fade-in {
            animation: fadeInAnimation 2s ease-in forwards;
            height: 500px;
        }
        .logo-container {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 99;
            width: 100%;
        }
        .logo-image {
            position: relative;
            width: 25%;
            margin: 10px;
            border-radius: 25%;
        }
        .text-top {
            font-size: 1.5em;
            color: cornflowerblue;
        }
        .text-bottom {
            font-size: 1.5em;
            color: cornflowerblue;
        }
        .overlay-text {
            position: absolute;
            top: 40px;
            left: 50%;
            transform: translateX(-50%);
            padding-bottom: 10px;
            color: cornflowerblue;
            border-bottom: 3px dashed #4169e1;
            font-weight: bold;
            font-size: 1em;
        }
    }
</style>
