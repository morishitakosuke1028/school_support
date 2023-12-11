<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    links: Array
});


const navigate = (url) => {
    router.visit(url);
};
</script>
<template>
    <nav aria-label="Page navigation">
        <ul class="inline-flex">
            <li v-for="(link, index) in links" :key="index">
                <template v-if="link.label === 'prev'">
                    <button v-if="link.url" @click="navigate(link.url)" class="h-10 px-5 text-indigo-600 transition-colors duration-150 focus:shadow-outline hover:bg-indigo-100">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                        <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                    </button>
                </template>
                <template v-else-if="link.label === 'next'">
                    <button v-if="link.url" @click="navigate(link.url)" class="h-10 px-5 text-indigo-600 transition-colors duration-150 focus:shadow-outline hover:bg-indigo-100">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                        <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                    </button>
                </template>
                <template v-else>
                    <button :class="['h-10 px-5 text-indigo-600 transition-colors focus:shadow-outline hover:bg-indigo-100', { 'text-white duration-150 bg-indigo-600 border border-indigo-600': link.active }]" @click="navigate(link.url)">
                    {{ link.label }}
                    </button>
                </template>
            </li>
        </ul>
    </nav>
</template>
