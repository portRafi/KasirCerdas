<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import 'primeicons/primeicons.css'

</script>

<template>
    <div class="w-full h-[100dvh] flex flex-col justify-between">
        <div class="flex flex-col justify-center items-center flex-grow">
            <img src="assets/rejected.png" alt="rejected" class="w-[130px] h-auto">
            <!-- <i class="pi pi-exclamation-triangle bg-red-500 px-6 py-6 rounded-full mb-4" style="font-size: 40px; color:white"></i> -->
            <h2 class="text-2xl font-normal text-gray-500">You can't access this page. Please go back to the <a :href="route('home')" class="cursor-pointer text-blue-500 underline font-bold">first page.</a></h2>
            <p class="text-xl text-gray-400">If you're a cashier, maybe it's not your shift.</p>
        </div>
        
        <footer class="bg-white w-full">
            <div class="border-t border-gray-100">
                <div class="mx-auto max-w-7xl px-4 md:px-9 py-6">
                    <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                        <p class="text-gray-500 text-sm text-center md:text-left">
                            © {{ new Date().getFullYear() }} KasirCerdas. All rights reserved.
                        </p>
                        <div class="flex space-x-6">
                            <a href="#" class="text-gray-500 hover:text-blue-500 transition-colors text-sm">Kebijakan Privasi</a>
                            <a href="#" class="text-gray-500 hover:text-blue-500 transition-colors text-sm">Syarat & Ketentuan</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
