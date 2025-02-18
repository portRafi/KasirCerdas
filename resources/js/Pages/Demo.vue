<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import 'primeicons/primeicons.css'

const props = defineProps({
    barangs: Array,
    metodepembayaran: Array,
    pajak: Number,
})

const paymentMethod = ref('');
const cart = ref([]);
const showModal = ref(false);
const selectedProduct = ref(null);
const quantity = ref(1);
const note = ref('');
const searchQuery = ref('');
const sortOption = ref('asc');

const filteredAndSortedProducts = computed(() => {
    const filteredProducts = Array.isArray(props.barangs) ? props.barangs.filter(barang => {
        const query = searchQuery.value.toLowerCase();
        return (
            barang.nama.toLowerCase().includes(query) ||
            barang.kategori.toLowerCase().includes(query) ||
            barang.kode.toLowerCase().includes(query)
        );
    }) : [];

    if (sortOption.value === 'asc') {
        filteredProducts.sort((a, b) => a.nama.localeCompare(b.nama));
    } else if (sortOption.value === 'desc') {
        filteredProducts.sort((a, b) => b.nama.localeCompare(a.nama));
    } else if (sortOption.value === 'price_asc') {
        filteredProducts.sort((a, b) => a.harga_jual - b.harga_jual);
    } else if (sortOption.value === 'price_desc') {
        filteredProducts.sort((a, b) => b.harga_jual - a.harga_jual);
    }
    return filteredProducts;
});

const openProductModal = (barang) => {
    selectedProduct.value = barang;
    quantity.value = 1;
    note.value = '';
    showModal.value = true;
};

const calculateTotalPajak = () => cart.value.reduce((sum, item) => sum + item.total_pajak, 0);
const calculateTotal = () => cart.value.reduce((sum, item) => sum + item.total_harga, 0);
const calculateSubtotal = () => cart.value.reduce((sum, item) => sum + item.total_harga_without_pajak_diskon, 0);
const calculateDiskonBarang = () => cart.value.reduce((sum, item) => sum + item.total_diskon, 0);

const addToCart = () => {
    if (selectedProduct.value) {
        const totalHargaPerItemAsli = selectedProduct.value.harga_beli * quantity.value;
        const totalHargaPerItem = selectedProduct.value.harga_jual;
        const totalHargaSebelumDiskonPajak = totalHargaPerItem * quantity.value;
        const totalPajak = totalHargaSebelumDiskonPajak * (props.pajak / 100);
        const totalDiskon = (selectedProduct.value.diskon <= 100) ? totalHargaPerItem * (selectedProduct.value.diskon / 100) : selectedProduct.value.diskon;
        const totalHargaAfterDiskon = totalHargaSebelumDiskonPajak - totalDiskon;
        const totalHarga = (totalHargaSebelumDiskonPajak - totalDiskon) + totalPajak;
        const existingProductIndex = cart.value.findIndex(item => item.kode === selectedProduct.value.kode);

        if (existingProductIndex !== -1) {
            const existingItem = cart.value[existingProductIndex];
            if (existingItem.quantity + quantity.value > selectedProduct.value.stok) {
                alert('Quantity di keranjang gabisa melebihi stok');
                return;
            }
            existingItem.total_harga += (totalHargaSebelumDiskonPajak + totalPajak)
            existingItem.quantity += quantity.value;
            existingItem.total_harga_without_pajak_diskon += totalHargaSebelumDiskonPajak;
            existingItem.total_harga_after_diskon += totalHargaAfterDiskon;
            existingItem.total_harga_after_pajak += totalHargaAfterDiskon + totalPajak;
            existingItem.total_harga_asli += totalHargaPerItemAsli;
            existingItem.total_diskon = totalDiskon;
            existingItem.total_pajak += totalPajak;
            existingItem.stok = selectedProduct.value.stok - existingItem.quantity;

        } else {
            if (quantity.value > selectedProduct.value.stok) {
                alert('Quantity di keranjang gabisa melebihi stok');
                return;
            }
            cart.value.push({
                kode: selectedProduct.value.kode,
                kategori: selectedProduct.value.kategori,
                nama: selectedProduct.value.nama,
                quantity: quantity.value,
                metode_pembayaran: paymentMethod.value,
                harga_jual: totalHargaPerItem,
                harga_beli: selectedProduct.value.harga_beli,
                total_harga: totalHarga,
                total_harga_without_pajak_diskon: totalHargaSebelumDiskonPajak,
                total_harga_after_diskon: totalHargaAfterDiskon,
                total_harga_after_pajak: totalHargaAfterDiskon + totalPajak,
                total_harga_asli: totalHargaPerItemAsli,
                total_diskon: totalDiskon,
                total_pajak: totalPajak,
                satuan: selectedProduct.value.satuan,
                keterangan: selectedProduct.value.keterangan,
                stok: selectedProduct.value.stok - quantity.value,
            });
        }

        showModal.value = false;
        console.log(cart);
    }
};


const formatCurrency = (value) => {
    if (!value) return "0";
    return Number(value).toLocaleString('id-ID');
};

const increaseQty = () => {
    quantity.value++
};

const decreaseQty = () => {
    if (quantity.value > 1) {
        quantity.value--;
    }
};

const removeFromCart = (index) => {
    cart.value.splice(index, 1);
};

const checkout = async () => {
    if (!paymentMethod.value) {
        alert('Silakan pilih metode pembayaran terlebih dahulu.');
        return;
    }

    if (cart.value.length === 0) {
        alert('Keranjang kosong. Silakan tambahkan produk.');
        return;
    }

    alert('checkout berhasil (DEMO)')
    cart.value = [];
};

</script>

<template>

    <Head title="Dashboard Kasir Demo" />
    <div class="overflow-hidden flex flex-col lg:flex-row h-screen bg-gray-100">
        <div class="w-full lg:w-1/4 bg-white p-4 pt-0 flex flex-col min-h-[90%] rounded-b-xl">
            <div class="overflow-y-auto flex-grow max-h-[70%]">
                <div class="flex pt-6 pb-5 items-center justify-left border-b">
                    <div class="hidden sm:flex text-center">
                        <img src="assets/kasircerdas_logo.png" alt="Kasir Cerdas Logo" class="w-auto h-[35px]">
                    </div>
                </div>

                <div v-for="(item, index) in cart" :key="index" class="flex items-center justify-between py-2 border-b">
                    <div class="flex-1">
                        <p class="font-medium text-sm">
                            {{ item.nama }}
                            <span v-if="item.note" class="text-sm text-gray-500 italic">Note: {{ item.note }}</span>
                        </p>
                        <p class="text-gray-600 text-sm">
                            {{ item.quantity }} x Rp {{ formatCurrency(item.harga_jual) }}
                        </p>
                    </div>
                    <p class="font-medium">Rp {{ formatCurrency(item.total_harga_without_pajak_diskon) }}</p>
                    <button @click="removeFromCart(index)" class="text-red-500 hover:underline ml-3">
                        <i class="pi pi-trash" style="font-size: 20px"></i>
                    </button>
                </div>
            </div>

            <div class="mt-3 pt-2 border-t">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Metode Pembayaran</span>
                    <select v-model="paymentMethod" class="px-4 lg:px-7 py-1 border rounded-lg">
                        <option v-for="mp in metodepembayaran" :key="mp.id" :value="mp.nama_mp">
                            {{ mp.nama_mp }}
                        </option>
                    </select>
                </div>
                <div class="mt-2">
                    <div class="flex justify-between mb-2 text-base">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">Rp {{ formatCurrency(calculateSubtotal()) }}</span>
                    </div>
                    <div class="flex justify-between mb-2 text-sm border-t pt-2">
                        <span class="text-gray-600">Total Pajak</span>
                        <span class="text-gray-600">Rp {{ formatCurrency(calculateTotalPajak()) }}</span>
                    </div>
                    <div class="flex justify-between mb-2 text-sm">
                        <span class="text-gray-600">Diskon Barang</span>
                        <span class="text-gray-600">- Rp {{ formatCurrency(calculateDiskonBarang()) }}</span>
                    </div>
                    <div class="flex justify-between border-t pt-2">
                        <span class="text-gray-600 text-base">Total</span>
                        <span class="text-base font-semibold">Rp {{ formatCurrency(calculateTotal()) }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-4 gap-2 mt-4">
                <button @click="checkout"
                    class="col-span-4 p-2 bg-blue-500 text-white font-semibold hover:bg-blue-600 rounded-xl mb-6">
                    Checkout ( Rp.<span>{{ formatCurrency(calculateTotal()) }}</span> )
                </button>
            </div>
        </div>

        <div class="flex-1 p-3 lg:p-5">
            <div class="bg-white rounded-xl p-3 lg:p-5 h-[100%]">
                <div class="flex flex-col sm:flex-row items-center justify-between mb-4 space-y-3 sm:space-y-0">
                    <div class="flex">
                        <div class="flex items-center w-full sm:w-auto">
                            <input type="text" placeholder="Cari barang..."
                                class="border border-gray-300 rounded-xl px-4 py-2 w-full sm:w-64"
                                v-model="searchQuery" />
                        </div>
                        <div class="relative w-full sm:w-auto">
                            <select v-model="sortOption"
                                class="border border-gray-300 rounded-xl px-4 py-2 cursor-pointer pr-8 sm:ml-3 w-full sm:w-auto">
                                <option value="asc">A - Z</option>
                                <option value="desc">Z - A</option>
                                <option value="price_asc">Harga ter-rendah</option>
                                <option value="price_desc">Harga ter-tinggi</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-flex rounded-md">
                        </span>
                        <i id="printer-icon" style="color: red; font-size: 21px"></i>
                    </div>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 pr-2 overflow-y-auto max-h-[92%]">
                    <div v-for="barang in filteredAndSortedProducts" :key="barang.id"
                        class="border rounded-xl p-3 lg:p-5 cursor-pointer hover:shadow-md transition-shadow w-full flex flex-col justify-center"
                        @click="openProductModal(barang)">
                        <div class="flex items-start gap-2 lg:gap-4">
                            <div
                                class="w-20 h-20 lg:w-24 lg:h-24 bg-gray-300 rounded-lg overflow-hidden flex-shrink-0 flex justify-center items-center">
                                <img :src="'assets/' + barang.foto" alt="demo_img">
                            </div>
                            <div class="flex flex-col flex-grow">
                                <h3 class="font-bold text-base lg:text-lg">
                                    {{ barang.nama }}
                                </h3>
                                <p class="text-xs lg:text-sm text-gray-600">
                                    {{ barang.kategori }} | <span class="font-bold">{{ barang.kode }}</span>
                                </p>
                                <p class="text-xs lg:text-sm text-gray-600">
                                    Stok: <span class="font-bold text-blue-600 mr-1">{{ formatCurrency(barang.stok)
                                        }}</span>
                                    <span class="text-xs font-normal text-gray-600">{{ barang.satuan }}</span>
                                </p>
                                <p class="font-bold text-base lg:text-lg pt-1 text-gray-600">
                                    Rp {{ formatCurrency(barang.harga_jual) }}
                                    <span class="text-xs lg:text-sm text-blue-600 font-normal">/ {{ barang.satuan
                                        }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg w-96 overflow-hidden">
                <div class="p-4 border-b">
                    <div class="flex items-center space-x-4">
                        <div>
                            <h3 class="font-semibold text-lg">{{ selectedProduct?.nama }}</h3>
                            <p class="text-gray-600">Rp <span class="font-bold">{{
                                formatCurrency(selectedProduct?.harga_jual) }} <span class="font-normal">/ {{
                                        selectedProduct?.satuan }}</span></span></p>
                            <p class="text-gray-600">Stok: <span class="font-bold">{{
                                formatCurrency(selectedProduct?.stok) }} {{ selectedProduct?.satuan }} </span>
                            </p>
                            <p class="text-gray-600">Ket: {{ selectedProduct?.keterangan }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                        <div class="flex items-center space-x-4">
                            <button @click="decreaseQty" class="px-4 py-2 border rounded-lg hover:bg-gray-50"> -
                            </button>
                            <span class="text-xl font-semibold jumlah">{{ quantity }}</span>
                            <button @click="increaseQty" class="px-4 py-2 border rounded-lg hover:bg-gray-50"> +
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea v-model="note"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows="3" placeholder="Add special instructions..."></textarea>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 flex justify-end space-x-2">
                    <button @click="showModal = false" class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                        Cancel
                    </button>
                    <button @click="addToCart" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>