<!-- resources/js/KasirApp.vue -->
<template>
    <div>
      <h1>Halaman Kasir</h1>
      <div>
        <!-- Contoh daftar produk -->
        <ul>
          <li v-for="product in products" :key="product.id">
            {{ product.name }} - Rp {{ product.price }}
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        products: [],
      };
    },
    mounted() {
      this.fetchProducts();
    },
    methods: {
      async fetchProducts() {
        try {
          const response = await axios.get('/api/products');
          this.products = response.data;
        } catch (error) {
          console.error('Error fetching products:', error);
        }
      },
    },
  };
  </script>
  