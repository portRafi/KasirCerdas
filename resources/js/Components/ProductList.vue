<template>
    <div class="product-list p-4">
      <h2 class="text-lg font-bold mb-4">Kategori</h2>
      <div class="grid grid-cols-3 gap-4">
        <div
          v-for="(product, index) in products"
          :key="index"
          class="product-item border rounded p-4 text-center"
        >
          <img :src="product.image" alt="" class="w-full h-24 object-cover mb-2" />
          <p class="font-bold">{{ product.name }}</p>
          <p class="text-gray-500">Rp {{ product.price }}</p>
          <button
            @click="addToCart(product)"
            class="mt-2 bg-blue-500 text-white px-4 py-1 rounded"
          >
            Tambah
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        products: [
          { name: 'Burger Combo', price: 50000, image: 'https://via.placeholder.com/100' },
          { name: 'Ayam Goreng', price: 35000, image: 'https://via.placeholder.com/100' },
          { name: 'Nasi Goreng', price: 25000, image: 'https://via.placeholder.com/100' },
          // Tambahkan produk lainnya
        ],
      };
    },
    methods: {
      addToCart(product) {
        this.$emit('addToOrder', product);
      },
    },
  };
  </script>
  
  <style scoped>
  .product-list {
    flex: 2;
    background-color: #fff;
  }
  .product-item {
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 8px;
    background-color: #f9f9f9;
  }
  </style>