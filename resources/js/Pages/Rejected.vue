<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import 'primeicons/primeicons.css'

</script>

<template>
    <div class="w-full h-screen flex flex-col justify-center items-center">
        <i class="pi pi-exclamation-triangle bg-red-500 px-6 py-6 rounded-full mb-4" style="font-size: 40px; color:white"></i>
        <h2 class="text-xl font-normal text-gray-500">You can't access this page. Please go back to the <a :href="route('home')" class="cursor-pointer text-blue-500 underline font-bold">first page.</a></h2>
    </div>
</template>