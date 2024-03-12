<script setup>
import { Head, Link } from '@inertiajs/vue3';

</script>
<template>
    <Head title="すくサポ　公式" />

    <div class="container mx-auto px-4">
        <main>
            <section id="features" class="my-10">
                <h2 class="text-2xl font-bold text-center">主な機能</h2>
                <!-- 機能一覧の内容 -->
            </section>
            <section id="testimonials" class="my-10">
                <h2 class="text-2xl font-bold text-center">ユーザー様の声</h2>
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
        <footer class="text-center py-5 bg-gray-200">
            © 2024 すくサポ. All rights reserved.
        </footer>
    </div>
  </template>
