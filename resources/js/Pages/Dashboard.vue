<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const cart = ref([
    
]);

const products = ref([
    { id: 1, name: 'BBQ Ayam', price: 22000, image: '/images/products/bbq-ayam.jpeg' },
    { id: 2, name: 'Beef Sambal', price: 30000, image: '/images/products/beef-sambal.jpg' },
    { id: 3, name: 'Ayam Goreng', price: 25000, image: '/images/products/beef-sambal.jpg' },
    { id: 4, name: 'Nasi Goreng', price: 20000, image: '/images/products/beef-sambal.jpg' },
    { id: 5, name: 'Mie Goreng', price: 18000, image: '/images/products/beef-sambal.jpg' },
    { id: 6, name: 'Capcay', price: 25000, image: '/images/products/beef-sambal.jpg' },
    { id: 7, name: 'Sate Ayam', price: 28000, image: '/images/products/beef-sambal.jpg' },
    { id: 8, name: 'Soto Ayam', price: 22000, image: '/images/products/beef-sambal.jpg' },
]);

const showModal = ref(false);
const selectedProduct = ref(null);
const quantity = ref(1);
const note = ref('');

// Menghitung total belanja
const calculateTotal = () => {
    return cart.value.reduce((sum, item) => sum + item.total, 0);
};


/**
 * Membuka modal untuk memilih produk yang akan di beli
 * dan mengatur nilai quantity dan note menjadi 1 dan kosong

/*************  ✨ Codeium Command ⭐  *************/
/******  23d3bdfa-9515-41e4-b79e-467b327916e1  *******/const openProductModal = (product) => {
    selectedProduct.value = product;
    quantity.value = 1;
    note.value = '';
    showModal.value = true;
};

// Menambahkan produk ke keranjang
const addToCart = () => {
    const total = selectedProduct.value.price * quantity.value;
    cart.value.push({
        name: selectedProduct.value.name,
        qty: quantity.value,
        price: selectedProduct.value.price,
        total: total,
        note: note.value,
    });
    showModal.value = false;
};

// Mengubah jumlah produk di keranjang
const increaseQty = () => {
    quantity.value++;
};

// Mengurangi quantity produk di keranjang
const decreaseQty = () => {
    if (quantity.value > 1) {
        quantity.value--;
    }
};

// Menghapus produk dari keranjang
const removeFromCart = (index) => {
    cart.value.splice(index, 1);
};

// Melakukan checkout
const checkout = () => {
    if (cart.value.length === 0) {
        alert('Keranjang kosong. Silakan tambahkan produk.');
        return;
    }
    alert('Checkout berhasil!');
    cart.value = [];
};
</script>


<template>
    <Head title="Dashboard kasir" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard kasir</h2>
        </template>

        <div class="flex h-[calc(100vh-150px)] bg-gray-100">
            <!-- Bagian Kiri - Cart -->
            <div class="w-1/3 bg-white p-4 flex flex-col">
                <div class="flex-1 overflow-y-auto">
                    <div v-for="(item, index) in cart" :key="index" class="flex items-center justify-between py-2 border-b">
                        <div class="flex-1">
                            <p class="font-medium">{{ item.name }}</p>
                            <p class="text-gray-600">
                                {{ item.qty }} x Rp {{ item.price.toLocaleString() }}
                            </p>
                            <p v-if="item.note" class="text-sm text-gray-500 italic">Note: {{ item.note }}</p>
                        </div>
                        <p class="font-medium">Rp {{ item.total.toLocaleString() }}</p>
                        <button @click="removeFromCart(index)" class="text-red-500 hover:underline">Hapus</button>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">Rp {{ calculateTotal().toLocaleString() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Rounding</span>
                        <span class="font-medium">0</span>
                    </div>
                    <div class="flex justify-between mt-4 pt-4 border-t">
                        <span class="text-lg font-semibold">Total</span>
                        <span class="text-lg font-semibold">Rp {{ calculateTotal().toLocaleString() }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-2 mt-4">
                    <button @click="checkout" class="col-span-4 p-2 bg-blue-500 text-white font-semibold hover:bg-blue-600">
                        Checkout
                    </button>
                </div>
            </div>

            <!-- Bagian Kanan - Products -->
             
            <div class="flex-1 p-5">
                <div class="bg-white rounded-lg p-5">
                    <div class="grid grid-cols-4 gap-4">
                        <div v-for="barangs in barangs" :key="barangs.id"
                            class="border rounded-lg p-2 cursor-pointer hover:shadow-md transition-shadow"
                            @click="openProductModal(product)">
                            <img :src="barang.image" :alt="barang.name"
                                class="w-full h-24 object-cover rounded-lg mb-2" />
                            <h3 class="font-medium text-sm">{{ barang.nama }}</h3>
                            <p class="text-sm text-gray-600">Rp {{ barang.harga_jual.toLocaleString() }}</p>
                            <p class="text-sm text-gray-600">Rp {{ barang.harga_jual}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Modal -->
            <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-96 overflow-hidden">
                    <div class="p-4 border-b">
                        <div class="flex items-center space-x-4">
                            <img v-if="selectedProduct" :src="selectedProduct.image" :alt="selectedProduct.name"
                                class="w-16 h-16 rounded-full object-cover" />
                            <div>
                                <h3 class="font-semibold text-lg">{{ selectedProduct?.name }}</h3>
                                <p class="text-gray-600">Rp {{ selectedProduct?.price.toLocaleString() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                            <div class="flex items-center space-x-4">
                                <button @click="decreaseQty"
                                    class="p-2 border rounded-lg hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14" />
                                    </svg>
                                </button>
                                <span class="text-xl font-semibold">{{ quantity }}</span>
                                <button @click="increaseQty"
                                    class="p-2 border rounded-lg hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 5v14M5 12h14" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            <textarea v-model="note"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                rows="3"
                                placeholder="Add special instructions..."></textarea>
                        </div>
                    </div>

                    <div class="p-4 bg-gray-50 flex justify-end space-x-2">
                        <button @click="showModal = false"
                            class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                            Cancel
                        </button>
                        <button @click="addToCart"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">                                                         
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

export default {
    props: {
        barang: Array,
    }
}