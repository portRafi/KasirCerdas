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

    isScrolled.value = window.scrollY > 0;
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
        <!-- Navbar -->
        <div :class="['fixed flex flex-col md:flex-row justify-between items-center w-full pb-3 md:pb-5 mb-[25px] px-4 md:px-9 top-0 z-50 transition-[box-shadow,padding] duration-300 ease-in-out', { 'backdrop-blur-lg': isScrolled }]"
            :style="{ paddingTop: isScrolled ? '18px' : '28px' }">
            <!-- Logo -->
            <div class="flex justify-between items-center w-full md:w-auto">
                <img src="assets/kasircerdas_logo.png" alt="Kasir Cerdas Logo" class="w-auto h-[30px] md:h-[35px] mb-[1px]">
                <!-- Mobile Menu Button -->
                <button @click="toggleMenu" class="md:hidden text-blue-500">
                    <i class="pi pi-bars text-xl"
                        style="font-size: 27px; color: rgba(87, 138, 234, 255)"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav :class="['flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-8 justify-center w-full',
                { 'hidden md:flex': !isMobileMenuOpen }]">
                <a href="#beranda" @click.prevent="scrollToSection('beranda')" 
                    class="text-base md:text-lg hover:text-blue-500 transition-colors"
                    :class="[{ 'border-b-2 rounded-md border-blue-500 text-blue-500': activeSection === 'beranda',
                    'text-blue-500': activeSection === 'beranda' || (isScrolled && activeSection === 'beranda'),
                    'text-slate-500': isScrolled && activeSection !== 'beranda' }]">Beranda</a>
                <a href="#fitur" @click.prevent="scrollToSection('fitur')"
                    class="text-base md:text-lg hover:text-blue-500 transition-colors"
                    :class="[{ 'border-b-2 rounded-md border-blue-500 text-blue-500': activeSection === 'fitur',
                    'text-blue-500': activeSection === 'fitur' || (isScrolled && activeSection === 'fitur'),
                    'text-slate-500': isScrolled && activeSection !== 'fitur',
                    'text-gray-400': !isScrolled }]">Fitur</a>
                <a href="#layanan" @click.prevent="scrollToSection('layanan')"
                    class="text-base md:text-lg hover:text-blue-500 transition-colors"
                    :class="[{ 'border-b-2 rounded-md border-blue-500 text-blue-500': activeSection === 'layanan',
                    'text-blue-500': activeSection === 'layanan' || (isScrolled && activeSection === 'layanan'),
                    'text-slate-500': isScrolled && activeSection !== 'layanan',
                    'text-gray-400': !isScrolled }]">Layanan</a>
                <a :href="route('demo')"
                    class="text-base md:text-lg hover:text-blue-500 transition-colors"
                    :class="['text-gray-400', { 'text-slate-500': isScrolled }]">Demo</a>
            </nav>

            <!-- Login Button -->
            <div v-if="canLogin" class="hidden md:block text-end">
                <template v-if="$page.props.auth.user">
                    <a :href="route('redirects')"
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

        <!-- Hero Section -->
        <section id="beranda" class="w-auto h-auto px-4 md:px-0">
            <div class="flex justify-center items-center cursor-pointer pb-5 mt-[140px]">
                <a :href="route('demo')"
                    class="flex justify-between items-center bg-blue-50 w-auto h-[47px] rounded-3xl pl-2 pr-4">
                    <i class="pi pi-spin pi-link bg-blue-500 px-2 py-2 rounded-full"
                        style="font-size: 15px; color:white"></i>
                    <p class="text-blue-500 font-normal ml-3">Demo - KasirCerdas</p>
                </a>
            </div>
            <div class="slogan text-center text-slate-900 text-3xl md:text-6xl pb-10 md:pb-20">
                <h3>Kunci Utama untuk Meningkatkan <br class="hidden md:block"> Efektivitas Penjualan</h3>
            </div>

            <!-- App Screenshots -->
            <div class="flex flex-col md:flex-row w-full h-auto px-4 md:px-9 space-y-4 md:space-y-0 md:space-x-4 justify-center pb-10 md:pb-20">
                <img src="assets/fotoapp_kiri.png" alt="fotoapp"
                    class="w-full md:w-auto h-auto max-w-full md:min-w-[150px] border-b-2 border-r-2 border-gray-100 rounded-xl">
                <img src="assets/fotoapp_tengah.png" alt="fotoapp"
                    class="w-full md:w-auto h-auto max-w-full md:min-w-[150px] rounded-xl border-2 border-gray-100">
                <img src="assets/fotoapp_kanan.png" alt="fotoapp"
                    class="w-full md:w-auto h-auto max-w-full md:min-w-[150px] rounded-xl border-2 border-gray-100">
            </div>

            <!-- Logo Scroll -->
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
                    <!-- ... (Logo scroll content remains the same) ... -->
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="fitur" class="w-auto h-auto px-4 md:px-9">
            <div class="slogan text-center text-slate-900 text-3xl md:text-4xl pb-10 md:pb-20 mt-20 md:mt-52 flex flex-col">
                <h3>Rasakan Pengalaman</h3>
                <h3 class="text-zinc-400 pt-1">Kasir Yang Modern Bersama Kami</h3>
            </div>

            <!-- Feature Grid -->
            <div class="flex flex-col w-full h-auto">
                <div class="flex flex-col h-auto w-full gap-4 mb-10">
                    <!-- First Row -->
                    <div class="flex flex-col md:flex-row w-full md:h-[500px] gap-4">
                        <div class="flex-1 bg-gray-100 rounded-2xl flex justify-center items-center p-4 md:p-0">
                            <img class="w-full md:w-[700px] h-auto rounded-xl" src="assets/layanan1.png" alt="">
                        </div>
                        <div class="flex-1 bg-gray-100 rounded-2xl flex justify-center items-center p-4 md:p-0">
                            <img class="w-full md:w-[250px] h-auto rounded-xl" src="assets/layanan2.png" alt="">
                        </div>
                    </div>
                    <!-- Second Row -->
                    <div class="flex flex-col md:flex-row w-full md:h-[500px] gap-4">
                        <div class="flex-1 bg-gray-100 rounded-2xl flex justify-center items-center p-4 md:p-0">
                            <img class="w-full md:w-[700px] h-auto rounded-xl" src="assets/layanan3.png" alt="">
                        </div>
                        <div class="flex-1 bg-gray-100 rounded-2xl flex justify-center items-center p-4 md:p-0">
                            <img class="w-full md:w-[690px] h-auto rounded-xl" src="assets/layanan4.png" alt="">
                        </div>
                    </div>
                </div>

                <!-- Feature Icons -->
                <div class="grid grid-cols-2 md:flex md:flex-row md:space-x-36 justify-center items-center w-full mt-5 gap-y-8 md:h-20">
                    <div class="flex flex-col justify-center items-center">
                        <i class="pi pi-desktop mb-4 md:mb-6" style="font-size: 27px; color: rgba(87, 138, 234, 255)"></i>
                        <p class="text-gray-500 text-sm md:text-base text-center">Tampilan Responsif</p>
                    </div>
                    <div class="flex flex-col justify-center items-center">
                        <i class="pi pi-database mb-4 md:mb-6" style="font-size: 27px; color: rgba(87, 138, 234, 255)"></i>
                        <p class="text-gray-500 text-sm md:text-base text-center">Manajemen Stok</p>
                    </div>
                    <div class="flex flex-col justify-center items-center">
                        <i class="pi pi-clock mb-4 md:mb-6" style="font-size: 27px; color: rgba(87, 138, 234, 255)"></i>
                        <p class="text-gray-500 text-sm md:text-base text-center">Real-Time Data</p>
                    </div>
                    <div class="flex flex-col justify-center items-center">
                        <i class="pi pi-users mb-4 md:mb-6" style="font-size: 27px; color: rgba(87, 138, 234, 255)"></i>
                        <p class="text-gray-500 text-sm md:text-base text-center">Manajemen Akun</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="layanan" class="layanan w-auto h-auto px-4 md:px-9">
            <div class="slogan text-center text-slate-900 text-3xl md:text-4xl mt-20 md:mt-52 pb-10 md:pb-20 flex flex-col">
                <h3>Tumbuhkan Bisnismu</h3>
                <h3 class="text-zinc-400 pt-1">Buat Pelanggan Terkesan</h3>
            </div>

            <div class="flex flex-col w-full h-auto mb-20 md:mb-40">
                <div class="flex flex-col h-auto w-full gap-4 mb-10">
                    <!-- First Service -->
                    <div class="flex flex-col md:flex-row w-full md:h-[500px] gap-4">
                        <div class="flex-1 flex flex-col bg-transparent justify-start items-start rounded-2xl p-6 md:px-20 md:py-10 border-t-2 border-l-2 border-gray-100">
                            <i class="pi pi-spin pi-microchip bg-blue-50 flex rounded-full w-16 h-16 md:w-20 md:h-20 mb-6 md:mb-10"
                                style="font-size: 28px; color: rgba(87, 138, 234, 255); display: flex; justify-content: center; align-items: center;"></i>
                            <h3 class="text-slate-900 text-2xl md:text-3xl text-left mb-4">Pemantauan Aktivitas Bisnis<br>dan Operasional</h3>
                            <p class="text-zinc-500 text-base md:text-lg">Pemantauan aktivitas bisnis seperti tabel, data pajak, dan riwayat yang memungkinkan Anda untuk meninjau transaksi terbaru sekaligus yang telah lewat, membantu Anda melacak pembayaran dan menyelesaikan masalah tagihan dengan lebih efisien.</p>
                        </div>
                        <div class="flex-1 bg-gray-100 rounded-2xl p-6 md:px-20 md:py-10 flex justify-center items-center">
                            <img class="h-auto md:h-[400px] w-full md:w-auto object-contain" src="assets/pemantauanaktivitasbisnis_img.png" alt="">
                        </div>
                    </div>

                    <!-- Second Service -->
                    <div class="flex flex-col-reverse md:flex-row w-full md:h-[500px] gap-4">
                        <div class="flex-1 bg-gray-100 rounded-2xl p-6 md:px-20 md:py-10 flex justify-center items-center">
                            <img class="h-auto md:h-[400px] w-full md:w-auto object-contain" src="assets/pemantauanpenjualan_img.png" alt="">
                        </div>
                        <div class="flex-1 flex flex-col bg-transparent justify-start items-start rounded-2xl p-6 md:px-20 md:py-10 border-b-2 border-r-2 border-gray-100">
                            <i class="pi pi-chart-pie bg-blue-50 flex rounded-full w-16 h-16 md:w-20 md:h-20 mb-6 md:mb-10"
                                style="font-size: 28px; color: rgba(87, 138, 234, 255); display: flex; justify-content: center; align-items: center;"></i>
                            <h3 class="text-slate-900 text-2xl md:text-3xl text-left mb-4">Pemantauan Penjualan untuk<br>Keputusan Bisnis yang Lebih Baik</h3>
                            <p class="text-zinc-500 text-base md:text-lg">Pemantauan penjualan yang memungkinkan Anda untuk melihat data penjualan secara real-time, memantau penjualan harian, mingguan, bulanan, dan tahunan, serta melihat data penjualan produk terlaris dan yang paling menguntungkan.</p>
                        </div>
                    </div>
                    
                </div>
                
            </div>
            <footer class="bg-white w-full">
        <!-- Main Footer Content -->
        <div class="mx-auto max-w-7xl px-4 md:px-9 pt-16 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Brand Section -->
                <div class="space-y-6">
                    <img src="assets/kasircerdas_logo.png" alt="Kasir Cerdas Logo" class="h-8 w-auto">
                    <p class="text-gray-500 text-sm">
                        Solusi kasir modern untuk mengembangkan bisnis Anda dengan teknologi yang efisien dan mudah digunakan.
                    </p>
                    <!-- Social Media Links -->
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-blue-500 transition-colors">
                            <i class="pi pi-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-500 transition-colors">
                            <i class="pi pi-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-500 transition-colors">
                            <i class="pi pi-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-500 transition-colors">
                            <i class="pi pi-linkedin text-xl"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-gray-900 font-semibold mb-6">Tautan Cepat</h3>
                    <ul class="space-y-4">
                        <li>
                            <a href="#beranda" class="text-gray-500 hover:text-blue-500 transition-colors">Beranda</a>
                        </li>
                        <li>
                            <a href="#fitur" class="text-gray-500 hover:text-blue-500 transition-colors">Fitur</a>
                        </li>
                        <li>
                            <a href="#layanan" class="text-gray-500 hover:text-blue-500 transition-colors">Layanan</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-500 hover:text-blue-500 transition-colors">Demo</a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-gray-900 font-semibold mb-6">Hubungi Kami</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start space-x-3">
                            <i class="pi pi-map-marker text-blue-500 mt-1"></i>
                            <span class="text-gray-500">Jl. Cilangkap RT01/14 No.04, Tapos, Depok, Jawa Barat, Indonesia</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="pi pi-phone text-blue-500"></i>
                            <span class="text-gray-500">+62 821-2345-6789</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="pi pi-envelope text-blue-500"></i>
                            <span class="text-gray-500">hello@ionbit.id</span>
                        </li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h3 class="text-gray-900 font-semibold mb-6">Newsletter</h3>
                    <p class="text-gray-500 mb-4">Berlangganan untuk mendapatkan informasi terbaru.</p>
                    <form @submit.prevent="subscribeNewsletter" class="space-y-4">
                        <input 
                            type="email" 
                            placeholder="Masukkan email Anda"
                            class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-blue-500"
                            v-model="email"
                        >
                        <button 
                            type="submit"
                            class="w-full bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors"
                        >
                            Berlangganan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
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
        </section>
        
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
