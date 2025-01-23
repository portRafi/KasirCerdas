<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Head } from '@inertiajs/vue3';
import 'primeicons/primeicons.css';

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

const activeSection = ref('beranda');
const isScrolled = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 0;

    const sections = ['beranda', 'fitur', 'layanan'];
    let foundActive = false;

    sections.forEach((section) => {
        const element = document.getElementById(section);
        const rect = element.getBoundingClientRect();

        if (rect.top <= 0 && rect.bottom >= 0) {
            if (activeSection.value !== section) {
                activeSection.value = section;
            }
            foundActive = true;
        }
    });

    if (!foundActive) {
        activeSection.value = '';
    }
};

const scrollToSection = (sectionId) => {
    const section = document.getElementById(sectionId);

    window.scrollTo({
        top: section.offsetTop - -30,
        behavior: 'smooth',
    });

    activeSection.value = sectionId;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onBeforeUnmount(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<template>

    <Head title="Welcome" />
    <div class="flex flex-col min-h-screen bg-white selection:bg-white selection:text-blue-500">
        <div :class="['fixed flex flex-row justify-between items-center w-full pb-5 mb-[25px] px-9 top-0 z-50 transition-[box-shadow,padding] duration-300 ease-in-out', { 'backdrop-blur-lg': isScrolled }]"
            :style="{ paddingTop: isScrolled ? '18px' : '28px' }">
            <img src="assets/kasircerdas_logo.png" alt="Kasir Cerdas Logo" class="w-auto h-[35px] mb-[1px]">
            <nav class="flex flex-row items-center space-x-8 justify-center w-full">
                <a href="#beranda" @click.prevent="scrollToSection('beranda')"
                    :class="['text-gray-400 text-lg hover:text-blue-500 transition-colors', { 'text-slate-500': isScrolled, 'border-b-2 rounded-md border-blue-500 text-blue-500': activeSection === 'beranda' }]">Beranda</a>
                <a href="#fitur" @click.prevent="scrollToSection('fitur')"
                    :class="['text-gray-400 text-lg hover:text-blue-500 transition-colors', { 'text-slate-500': isScrolled, 'border-b-2 rounded-md border-blue-500 text-blue-500': activeSection === 'fitur' }]">Fitur</a>
                <a href="#layanan" @click.prevent="scrollToSection('layanan')"
                    :class="['text-gray-400 text-lg hover:text-blue-500 transition-colors', { 'text-slate-500': isScrolled, 'border-b-2 rounded-md border-blue-500 text-blue-500': activeSection === 'layanan' }]">Layanan</a>
                <a :href="route('demo')"
                    :class="['text-gray-400 text-lg hover:text-blue-500 transition-colors', { 'text-slate-500': isScrolled }]">Demo</a>
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
        <section id="beranda" class="w-auto h-auto">
            <div class="flex justify-center items-center cursor-pointer pb-5 mt-[140px]">
                <a :href="route('demo')"
                    class="flex justify-between items-center bg-blue-50 w-auto h-[47px] rounded-3xl pl-2 pr-4">
                    <i class="pi pi-spin pi-link bg-blue-500 px-2 py-2 rounded-full"
                        style="font-size: 15px; color:white"></i>
                    <p class="text-blue-500 font-normal ml-3">Demo - KasirCerdas</p>
                </a>
            </div>
            <div class="slogan text-center text-slate-900 text-6xl pb-20">
                <h3>Kunci Utama untuk Meningkatkan <br> Efektivitas Penjualan</h3>
            </div>
            <div class="flex flex-row w-full h-auto px-9 space-x-4 justify-center pb-20">
                <img src="assets/fotoapp_kiri.png" alt="fotoapp"
                    class="w-auto h-auto max-w-full min-w-[150px] border-b-2 border-r-2 border-gray-100 rounded-xl">
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
        </section>
        <section id="fitur" class="w-auto h-auto">
            <div class="slogan text-center text-slate-900 text-4xl pb-20 mt-52 flex flex-col">
                <h3>Rasakan Pengalaman</h3>
                <h3 class="text-zinc-400 pt-1">Kasir Yang Modern Bersama Kami</h3>
            </div>
            <div class="flex flex-col w-full h-auto px-9 ">
                <div class="flex flex-col h-auto w-full gap-4 mb-10">
                    <div class="flex w-full h-[500px] gap-4">
                        <div class="flex-1 bg-gray-100 rounded-2xl flex justify-center items-center">
                            <img class="w-[700px] h-auto rounded-xl" src="assets/layanan1.png" alt="">
                        </div>
                        <div class="flex-1 bg-gray-100 rounded-2xl flex justify-center items-center">
                            <img class="w-[250px] h-auto rounded-xl" src="assets/layanan2.png" alt="">
                        </div>
                    </div>
                    <div class="flex w-full h-[500px] gap-4">
                        <div class="flex-1 bg-gray-100 rounded-2xl flex justify-center items-center">
                            <img class="w-[700px] h-auto rounded-xl" src="assets/layanan3.png" alt="">
                        </div>
                        <div class="flex-1 bg-gray-100 rounded-2xl flex justify-center items-center">
                            <img class="w-[690px] h-auto rounded-xl" src="assets/layanan4.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="flex flex-row space-x-36 justify-center items-center w-full mt-5 h-20">
                    <div class="flex flex-col justify-center items-center">
                        <i class="pi pi-desktop mb-6" style="font-size: 27px; color: rgba(87, 138, 234, 255)"></i>
                        <p class="text-gray-500">Tampilan Responsif</p>
                    </div>
                    <div class="flex flex-col justify-center items-center">
                        <i class="pi pi-database mb-6" style="font-size: 27px; color: rgba(87, 138, 234, 255)"></i>
                        <p class="text-gray-500">Manajemen Stok</p>
                    </div>
                    <div class="flex flex-col justify-center items-center">
                        <i class="pi pi-clock mb-6" style="font-size: 27px; color: rgba(87, 138, 234, 255)"></i>
                        <p class="text-gray-500">Real-Time Data</p>
                    </div>
                    <div class="flex flex-col justify-center items-center">
                        <i class="pi pi-users mb-6" style="font-size: 27px; color: rgba(87, 138, 234, 255)"></i>
                        <p class="text-gray-500">Manajemen Akun</p>
                    </div>
                </div>
            </div>
        </section>
        <section id="layanan" class="layanan w-auto h-auto">
            <div class="slogan text-center text-slate-900 text-4xl mt-52 pb-20 flex flex-col">
                <h3>Tumbuhkan Bisnismu</h3>
                <h3 class="text-zinc-400 pt-1">Buat Pelanggan Terkesan</h3>
            </div>
            <div class="flex flex-col w-full h-auto px-9 mb-40">
                <div class="flex flex-col h-auto w-full gap-4 mb-10">
                    <div class="flex w-full h-[500px] gap-4">
                        <div
                            class="flex-1 flex flex-col bg-transparent justify-start items-start rounded-2xl px-20 py-10 border-t-2 border-l-2 border-gray-100">
                            <i class="pi pi-spin pi-microchip bg-blue-50 flex rounded-full w-20 h-20 mb-10"
                                style="font-size: 28px; color: rgba(87, 138, 234, 255); display: flex; justify-content: center; align-items: center;"></i>
                            <h3 class="text-slate-900 text-3xl text-left mb-4">Pemantauan Aktivitas Bisnis<br>dan
                                Operasional</h3>
                            <p class="text-zinc-500 text-lg">Pemantauan aktivitas bisnis seperti tabel, data pajak, dan
                                riwayat
                                yang
                                memungkinkan Anda untuk meninjau transaksi terbaru sekaligus yang telah lewat, membantu
                                Anda
                                melacak
                                pembayaran dan menyelesaikan masalah tagihan dengan lebih efisien.
                            </p>
                        </div>
                        <div class="flex-1 bg-gray-100 rounded-2xl px-20 py-10 flex justify-center items-center">
                            <img class="h-[400px] w-auto" src="assets/pemantauanaktivitasbisnis_img.png" alt="">
                        </div>
                    </div>
                    <div class="flex w-full h-[500px] gap-4">
                        <div class="flex-1 bg-gray-100 rounded-2xl px-20 py-10 flex justify-center items-center">
                            <img class="h-[400px] w-auto" src="assets/pemantauanpenjualan_img.png" alt="">
                        </div>
                        <div
                            class="flex-1 flex flex-col bg-transparent justify-start items-start rounded-2xl px-20 py-10 border-b-2 border-r-2 border-gray-100">
                            <i class="pi pi-chart-pie bg-blue-50 flex rounded-full w-20 h-20 mb-10"
                                style="font-size: 28px; color: rgba(87, 138, 234, 255); display: flex; justify-content: center; align-items: center;"></i>
                            <h3 class="text-slate-900 text-3xl text-left mb-4">Pemantauan Penjualan untuk<br>Keputusan
                                Bisnis
                                yang Lebih Baik</h3>
                            <p class="text-zinc-500 text-lg">Halaman ini menampilkan grafik dalam Real-Time untuk
                                melacak
                                penjualan, keuntungan, dan lainnya. Ini juga membantu Anda membuat pembaruan bisnis yang
                                terinformasi dan memastikan efisiensi operasional.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- <div class="flex flex-col items-center justify-center w-full h-20 bg-blue-500 text-white">
        <p class="text-center">© 2025 KasirCerdas. All rights reserved.</p>
    </div> -->

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
