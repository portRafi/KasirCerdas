<!-- <script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    barangs: Array,
    metodepembayaran: Array,
    pajak: Array,
});
const paymentMethod = ref('');

const cart = ref([]);
const showModal = ref(false);
const selectedProduct = ref(null);
const quantity = ref(1);
const note = ref('');

const calculateTotal = () => {
    return cart.value.reduce((sum, item) => sum + item.total_harga, 0);
};

const calculateSubtotal = () => {
    return cart.value.reduce((sum, item) => sum + item.total_harga_without_pajak_diskon, 0);
}

const calculateDiskonBarang = () => {
    return cart.value.reduce((sum, item) => sum + item.total_diskon, 0);
}

const openProductModal = (barang) => {
    selectedProduct.value = barang;
    quantity.value = 1;
    note.value = '';
    showModal.value = true;
};

const addToCart = () => {
    if (selectedProduct.value) {

        const totalHargaPerItem = selectedProduct.value.harga_jual;
        const discountPerItem = (selectedProduct.value.diskon <= 100) ? totalHargaPerItem * (selectedProduct.value.diskon / 100) : selectedProduct.value.diskon;
        const totalHargaAfterDiskonPerItem = totalHargaPerItem;
        const totalHarga = totalHargaAfterDiskonPerItem * quantity.value;
        const totalDiskon = discountPerItem;
        const existingProductIndex = cart.value.findIndex(item => item.kode === selectedProduct.value.kode);

        if (existingProductIndex !== -1) {
            cart.value[existingProductIndex].quantity += quantity.value;
            cart.value[existingProductIndex].total_harga += totalHarga;
            cart.value[existingProductIndex].total_harga_without_pajak_diskon += totalHargaPerItem * quantity.value;
            cart.value[existingProductIndex].total_diskon = discountPerItem;
        } else {
            cart.value.push({
                kode: selectedProduct.value.kode,
                kategori: selectedProduct.value.kategori,
                nama: selectedProduct.value.nama,
                quantity: quantity.value,
                harga_jual: totalHargaPerItem,
                harga_beli: selectedProduct.value.harga_beli,
                total_harga: totalHarga - totalDiskon,
                total_harga_without_pajak_diskon: totalHargaPerItem * quantity.value,
                total_diskon: totalDiskon,
                note: note.value,
            });
        }

        showModal.value = false;
        console.log(cart);
    }
};



const increaseQty = () => {
    quantity.value++;
};

const decreaseQty = () => {
    if (quantity.value > 1) {
        quantity.value--;
    }
};

const removeFromCart = (index) => {
    cart.value.splice(index, 1);
};

const checkout = () => {
    if (cart.value.length === 0) {
        alert('Keranjang kosong. Silakan tambahkan produk.');
        return;
    }
    console.log(cart)
    alert('Checkout berhasil!');
    cart.value = [];
};
</script> -->

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    barangs: Array,
    metodepembayaran: Array,
    pajak: Array,
});

const paymentMethod = ref('');
const cart = ref([]);
const showModal = ref(false);
const selectedProduct = ref(null);
const quantity = ref(1);
const note = ref('');
const printer = ref(null);
const writer = ref(null);
const printerStatus = ref('OFF');
const deviceName = ref('');
const printerStatusClass = ref('badge bg-danger');

const calculateTotal = () => cart.value.reduce((sum, item) => sum + item.total_harga, 0);
const calculateSubtotal = () => cart.value.reduce((sum, item) => sum + item.total_harga_without_pajak_diskon, 0);
const calculateDiskonBarang = () => cart.value.reduce((sum, item) => sum + item.total_diskon, 0);

const openProductModal = (barang) => {
    selectedProduct.value = barang;
    quantity.value = 1;
    note.value = '';
    showModal.value = true;
};

const addToCart = () => {
    if (selectedProduct.value) {

        const totalHargaPerItem = selectedProduct.value.harga_jual;
        const discountPerItem = (selectedProduct.value.diskon <= 100) ? totalHargaPerItem * (selectedProduct.value.diskon / 100) : selectedProduct.value.diskon;
        const totalHargaAfterDiskonPerItem = totalHargaPerItem;
        const totalHarga = totalHargaAfterDiskonPerItem * quantity.value;
        const totalDiskon = discountPerItem;
        const existingProductIndex = cart.value.findIndex(item => item.kode === selectedProduct.value.kode);

        if (existingProductIndex !== -1) {
            cart.value[existingProductIndex].quantity += quantity.value;
            cart.value[existingProductIndex].total_harga += totalHarga;
            cart.value[existingProductIndex].total_harga_without_pajak_diskon += totalHargaPerItem * quantity.value;
            cart.value[existingProductIndex].total_diskon = discountPerItem;
        } else {
            cart.value.push({
                kode: selectedProduct.value.kode,
                kategori: selectedProduct.value.kategori,
                nama: selectedProduct.value.nama,
                quantity: quantity.value,
                harga_jual: totalHargaPerItem,
                harga_beli: selectedProduct.value.harga_beli,
                total_harga: totalHarga - totalDiskon,
                total_harga_without_pajak_diskon: totalHargaPerItem * quantity.value,
                total_diskon: totalDiskon,
                note: note.value,
            });
        }

        showModal.value = false;
        console.table(cart);
    }
};


const increaseQty = () => {
    quantity.value++;
};

const decreaseQty = () => {
    if (quantity.value > 1) {
        quantity.value--;
    }
};

const removeFromCart = (index) => {
    cart.value.splice(index, 1);
};

const checkout = () => {
    if (cart.value.length === 0) {
        alert('Keranjang kosong. Silakan tambahkan produk.');
        return;
    }
    print(cart.value);
    cart.value = [];
};

// Printer Methods
const connect = async () => {
    if (printer.value && writer.value) {
        alert('Printer sudah terhubung!');
        return;
    }

    if (!('serial' in navigator)) {
        alert('Browser Anda tidak mendukung Web Serial API.');
        return;
    }

    try {
        const port = await navigator.serial.requestPort();
        printer.value = port;
        deviceName.value = 'Menghubungkan...';
        await printer.value.open({ baudRate: 9600 });
        writer.value = printer.value.writable.getWriter();
        printerStatus.value = 'CONNECTED';
        printerStatusClass.value = 'badge bg-primary';
    } catch (error) {
        console.error('Error saat menghubungkan ke printer:', error);
        alert('Gagal menghubungkan ke printer.');
    }
};

const print = async () => {
    if (!printer.value || !writer.value) {
        alert('Pastikan printer sudah terhubung.');
        return;
    }

    const printable = {
        Align: {
            center: (text) => '\x1B' + '\x61' + '\x31' + text,
            left: (text) => '\x1B' + '\x61' + '\x00' + text,
            right: (text) => '\x1B' + '\x61' + '\x02' + text,
            reset: () => '\x1B' + '\x61' + '\x31' + '\x1D' + '\x21' + '\x00' + '\n'.repeat(2) + '\r'
        },
        Keyboard: {
            enter: (count) => '\n'.repeat(count) + '\r',
        },
        Font: {
            normal: (text) => '\x1D' + '\x21' + '\x00' + text,
            large: (text) => '\x1D' + '\x21' + '\x11' + text,
        },
        Misc: {
            centerLine: (count) => '\x1B' + '\x61' + '\x31' + '-'.repeat(count)
        }
    };

    const texts = [
        printable.Align.reset(),
        printable.Align.center(printable.Font.normal('PT. Ionbit Cafe')),
        printable.Keyboard.enter(2),
    ];

    cart.value.forEach((item) => {
        texts.push(printable.Align.left(printable.Font.large    (`${item.nama}`)));
        texts.push(printable.Keyboard.enter(1));
        texts.push(printable.Misc.centerLine(10));
        texts.push(printable.Keyboard.enter(2));
        texts.push(printable.Keyboard.enter(2));
        texts.push(printable.Keyboard.enter(2));
        texts.push(
            printable.Align.left(
                printable.Font.normal(
                    `Qty: ${item.quantity} x ${item.harga_jual} = Rp ${item.total_harga.toLocaleString()}`
                )
            )
        );
        texts.push(printable.Keyboard.enter(1));
    });

    texts.push(
        printable.Align.left(printable.Font.normal(`Subtotal: Rp ${calculateSubtotal().toLocaleString()}`)),
        printable.Keyboard.enter(1),
        printable.Align.left(printable.Font.normal(`Total: Rp ${calculateTotal().toLocaleString()}`)),
        printable.Keyboard.enter(2),
        printable.Align.center(printable.Font.normal('Terima Kasih')),
        printable.Align.reset()
    );

    try {
        for (let text of texts) {
            const encoder = new TextEncoder();
            const encodedText = encoder.encode(text);
            await writer.value.write(encodedText);
        }
        alert('Cetak selesai!');
    } catch (error) {
        console.error('Error saat mencetak:', error);
        alert('Gagal mencetak.');
    }
};
</script>

<template>

    <Head title="Dashboard kasir " />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-left">Point Of Sales | Ionbit</h2>
            <div>
                <div class="status">
                    <span :class="printerStatusClass">{{ printerStatus }}</span>
                </div>
                <button @click="connect" class="btnConnect">Connect</button>
                <button @click="print" class="btnPrint">Print</button>
            </div>
        </template>

        <div class="flex h-[calc(100vh-150px)] bg-gray-100">
            <!-- Bagian Kiri - Cart -->
            <div class="w-1/4 bg-white p-4 flex flex-col">
                <div class="flex-1 overflow-y-auto">
                    <div v-for="(item, index) in cart" :key="index"
                        class="flex items-center justify-between py-2 border-b">
                        <div class="flex-1">
                            <p class="font-medium text-sm">{{ item.nama }} <span v-if="item.note"
                                    class="text-sm text-gray-500 italic">Note: {{ item.note }}</span></p>
                            <p class="text-gray-600 text-sm">
                                {{ item.quantity }} x Rp {{ item.harga_jual.toLocaleString() }}
                            </p>
                        </div>
                        <p class="font-medium">Rp {{ item.total_harga.toLocaleString() }}</p>
                        <button @click="removeFromCart(index)" class="text-red-500 hover:underline ml-3">Hapus</button>
                    </div>
                </div>

                <div class="mt-3 pt-2 border-t">
                    <div class="flex justify-between items-center ">
                        <span class="text-gray-600">Metode Pembayaran</span>
                        <select v-model="paymentMethod" class="px-7 py-1 border rounded-md">
                            <option v-for="mp in metodepembayaran" :key="mp.id" :value='mp.nama_mp'>{{ mp.nama_mp }}
                            </option>
                        </select>
                    </div>
                    <div class="mt-2">
                        <div class="flex justify-between mb-2 text-base">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">Rp {{ calculateSubtotal().toLocaleString() }}</span>
                        </div>
                        <div class="flex justify-between mb-2 text-sm border-t pt-2">
                            <span class="text-gray-600">PPN</span>
                            <span class="text-gray-600 ">Rp {{ calculateSubtotal().toLocaleString() }}</span>
                        </div>
                        <div class="flex justify-between mb-2 text-sm">
                            <span class="text-gray-600">Pajak Layanan</span>
                            <span class="text-gray-600 ">- Rp {{ calculateDiskonBarang().toLocaleString() }}</span>
                        </div>
                        <div class="flex justify-between mb-2 text-sm ">
                            <span class="text-gray-600">Diskon Barang</span>
                            <span class="text-gray-600 ">- Rp {{ calculateDiskonBarang().toLocaleString() }}</span>
                        </div>

                        <div class="flex justify-between border-t pt-2">
                            <span class="text-gray-600 text-base">Total</span>
                            <span class="text-base font-semibold">Rp {{ calculateTotal().toLocaleString() }}</span>
                        </div>
                        <!-- <div class="flex justify-between mt-4 pt-4 border-t">
                        </div> -->
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-2 mt-4">
                    <button @click="checkout"
                        class="col-span-4 p-2 bg-blue-500 text-white font-semibold hover:bg-blue-600 rounded-lg">
                        Checkout
                    </button>
                </div>
            </div>

            <!-- Bagian Kanan - Products -->

            <div class="flex-1 p-5">
                <div class="bg-white rounded-lg p-5">
                    <div class="grid grid-cols-4 gap-4">
                        <div v-for="barang in barangs" :key="barang.id"
                            class="border rounded-lg p-5 cursor-pointer hover:shadow-md transition-shadow"
                            @click="openProductModal(barang)">
                            <h3 class="font-bold text-lg">{{ barang.nama }} - <span class="text-blue-600">{{ barang.stok
                                    }}</span></h3>
                            <p class="text-m text-gray-600">{{ barang.kategori }} | <span class="font-bold">{{
                                barang.kode
                                    }}</span></p>
                            <p class="font-bold text-lg pt-1 text-gray-600">Rp {{ barang.harga_jual }} <span
                                    class="text-sm text-blue-600 font-normal">/ {{ barang.satuan }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Modal -->
            <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-96 overflow-hidden">
                    <div class="p-4 border-b">
                        <div class="flex items-center space-x-4">
                            <div>
                                <h3 class="font-semibold text-lg">{{ selectedProduct?.nama }}</h3>
                                <p class="text-gray-600">Rp {{ selectedProduct?.harga_jual.toLocaleString() }}</p>
                                <p class="text-gray-600">Ket: {{ selectedProduct?.keterangan }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                            <div class="flex items-center space-x-4">
                                <button @click="decreaseQty" class="p-2 border rounded-lg hover:bg-gray-50">
                                    <!-- SVG for Decrease -->
                                </button>
                                <span class="text-xl font-semibold jumlah">{{ quantity }}</span>
                                <!-- Display Quantity -->
                                <button @click="increaseQty" class="p-2 border rounded-lg hover:bg-gray-50">
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
