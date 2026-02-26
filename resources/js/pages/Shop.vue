<script setup lang="ts">
import AppLayout from '../layouts/main.vue'
import CategoryFilters from '../components/mycategories.vue'
import ProductGrid from '../components/myproduct.vue'
import { ref, computed } from 'vue'
import type { Product } from '../types/Product'

const props = defineProps<{ products: Product[] }>()

const category = ref('all')

const filtered = computed(() =>
  category.value === 'all'
    ? props.products
    : props.products.filter(p => p.category === category.value)
)
</script>

<template>
  <AppLayout>
    <main class="main-content">      
       
    <div class="container">
         <CategoryFilters :active="category" @change="category = $event" />
        <ProductGrid :products="filtered" />   
      


    </div> </main>
  </AppLayout>
</template>