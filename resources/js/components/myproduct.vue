<script setup lang="ts">
import ProductCard from './myproductcard.vue'
import type { Product } from '../types/Product'

defineProps<{ products: Product[] }>()
</script>

<template>
  <div class="products-grid">
    <ProductCard v-for="p in products" :key="p.id" :product="p" />
  </div>
</template>
