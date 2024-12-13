<template>
    <div class="order-summary p-4 bg-gray-100 border-r">
      <h2 class="text-lg font-bold mb-4">Pesanan Baru</h2>
      <table class="w-full border-collapse">
        <thead>
          <tr class="border-b">
            <th class="text-left">Nama</th>
            <th class="text-left">Quantity</th>
            <th class="text-right">Total</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(order, index) in orders" :key="index" class="border-b">
            <td>{{ order.name }}</td>
            <td>
              <button @click="changeQty(order, -1)" class="px-2">-</button>
              {{ order.qty }}
              <button @click="changeQty(order, 1)" class="px-2">+</button>
            </td>
            <td class="text-right">Rp {{ order.total }}</td>
          </tr>  
        </tbody>
      </table>
      <div class="mt-4 text-right font-bold">
        Total: Rp {{ total }}
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      orders: Array,
      total: Number,
    },
    methods: {
      changeQty(order, amount) {
        const updatedOrders = this.orders.map((item) => {
          if (item.name === order.name) {
            const newQty = item.qty + amount;
            if (newQty > 0) {
              return {
                ...item,
                qty: newQty,
                total: newQty * item.price,
              };
            }
            return null; // Jika qty = 0, hapus item
          }
          return item;
        }).filter((item) => item !== null);
  
        this.$emit('updateOrder', updatedOrders);
      },
    },
  };
  </script>
  
  <style scoped>
  .order-summary {
    flex: 1;
  }
  table {
    width: 100%;
    text-align: left;
    margin-bottom:11px;
  }
  </style>