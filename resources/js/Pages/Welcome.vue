<script setup>
import { Head, Link } from '@inertiajs/vue3';
import 'primeicons/primeicons.css'

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>

    <Head title="Welcome" />

    <div class="flex flex-col min-h-screen bg-white selection:text-white">
        <div class="flex flex-row justify-between items-center w-full pb-[65px] pt-6 px-9">
            <img src="assets/kasircerdas_logo.png" alt="Kasir Cerdas Logo" class="w-auto h-[35px]">
            <nav class="flex flex-row items-center space-x-8 justify-center w-full">
                <a href="#" class="text-gray-400 text-lg hover:text-blue-500 transition-colors">Fitur</a>
                <a href="#" class="text-gray-400 text-lg hover:text-blue-500 transition-colors">Layanan</a>
                <a href="#" class="text-gray-400 text-lg hover:text-blue-500 transition-colors">Ulasan</a>
                <a href="#" class="text-gray-400 text-lg hover:text-blue-500 transition-colors">Tentang</a>
                <a :href="route('demo')" class="text-gray-400 text-lg hover:text-blue-500 transition-colors">Demo</a>
            </nav>
            <div v-if="canLogin" class=" text-end">
                <template v-if="$page.props.auth.user">
                    <a :href="route('pos')"
                        class="flex border-2 border-blue-500 rounded-3xl px-6 py-[6px] items-center text-blue-500 font-bold hover:bg-blue-500 hover:text-white transition-colors">
                        Dashboard
                    </a>
                </template>

                <template v-else>
                    <a :href="route('login')"
                        class="flex border-2 border-blue-500 rounded-3xl px-6 py-[6px] items-center text-blue-500 font-bold hover:bg-blue-500 hover:text-white transition-colors">
                        Masuk
                    </a>
                </template>
            </div>

        </div>
        <div class="flex justify-center items-center cursor-pointer pb-10">
            <a :href="route('demo')"
                class="flex justify-between items-center bg-blue-100 w-auto h-[47px] rounded-3xl pl-2 pr-4">
                <i class="pi pi-spin pi-link bg-blue-500 px-2 py-2 rounded-full"
                    style="font-size: 15px; color:white"></i>
                <p class="text-blue-500 font-bold ml-3">Demo - KasirCerdas</p>
            </a>
        </div>
        <div class="slogan text-center text-slate-900 text-6xl pb-20">
            <h3>Kunci Utama untuk Meningkatkan <br> Efektivitas Penjualan</h3>
        </div>
        <div class="flex flex-row w-full h-auto px-9 space-x-4 justify-center pb-20">
            <img src="assets/fotoapp_kiri.png" alt="fotoapp" class="w-auto h-auto max-w-full min-w-[150px] rounded-xl ">
            <img src="assets/fotoapp_tengah.png" alt="fotoapp"
                class="w-auto h-auto max-w-full min-w-[150px] rounded-xl border-2 border-gray-100">
            <img src="assets/fotoapp_kanan.png" alt="fotoapp"
                class="w-auto h-auto max-w-full min-w-[150px] rounded-xl border-2 border-gray-100">
        </div>
        <div class="flex overflow-hidden w-full h-40">
            <div class="infinite-scroll flex justify-center items-center">
                <img src="assets/ionbit.png" alt="ionbitlogo" class="h-[24px] mr-20">
                <img src="assets/starbhak.png" alt="starbhaklogo" class="h-[65px] mt-4 mr-20">
                <img src="assets/ionbit.png" alt="ionbitlogo" class="h-[24px] mr-20">
                <img src="assets/starbhak.png" alt="starbhaklogo" class="h-[65px] mt-4 mr-20">
                <img src="assets/ionbit.png" alt="ionbitlogo" class="h-[24px] mr-20">
                <img src="assets/starbhak.png" alt="starbhaklogo" class="h-[65px] mt-4 mr-20">
                <img src="assets/ionbit.png" alt="ionbitlogo" class="h-[24px] mr-20">
                <img src="assets/starbhak.png" alt="starbhaklogo" class="h-[65px] mt-4 mr-20">
                <img src="assets/ionbit.png" alt="ionbitlogo" class="h-[24px] mr-20">
                <img src="assets/starbhak.png" alt="starbhaklogo" class="h-[65px] mt-4 mr-20">
                <img src="assets/ionbit.png" alt="ionbitlogo" class="h-[24px] mr-20">
                <img src="assets/starbhak.png" alt="starbhaklogo" class="h-[65px] mt-4 mr-20">
                <img src="assets/ionbit.png" alt="ionbitlogo" class="h-[24px] mr-20">
                <img src="assets/starbhak.png" alt="starbhaklogo" class="h-[65px] mt-4 mr-20">
                <img src="assets/ionbit.png" alt="ionbitlogo" class="h-[24px] mr-20">
                <img src="assets/starbhak.png" alt="starbhaklogo" class="h-[65px] mt-4 mr-20">
                <img src="assets/ionbit.png" alt="ionbitlogo" class="h-[24px] mr-20">
                <img src="assets/starbhak.png" alt="starbhaklogo" class="h-[65px] mt-4 mr-20">
            </div>
        </div>


    </div>
</template>

<style>
@keyframes scrollRightToLeft {
    0% {
        transform: translateX(0);
    }

    100% {
        transform: translateX(-100%);
    }
}

.infinite-scroll {
    display: flex;
    animation: scrollRightToLeft 30s linear infinite;
}

.infinite-scroll img {
    filter: grayscale(100%) brightness(120%);
    transition: filter 0.3s ease;
}

.infinite-scroll img:hover {
    filter: grayscale(0%);
}
</style>
