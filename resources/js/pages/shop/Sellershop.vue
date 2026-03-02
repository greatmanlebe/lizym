
<script setup lang="ts">
import AppLayout from '@/layouts/main.vue'
import CategoryFilters from '@/components/mycategories.vue'
import ProductGrid from '@/components/myproduct.vue'
import { ref, computed } from 'vue'
import type { Product } from '@/types/Product'
import HeroSection from '@/components/mybannerseller.vue'
const props = defineProps<{ products: Product[] }>()

const category = ref('all')

const filtered = computed(() =>
  category.value === 'all'
    ? props.products
    : props.products.filter(p => p.category === category.value)
)

import { usePage } from '@inertiajs/vue3'

const page = usePage()
const seller = page.props.seller
const products = page.props.products
</script>

<template>
  <AppLayout>
    <main class="main-content">      
           <HeroSection />
        <div class="container">
         <CategoryFilters :active="category" @change="category = $event" />
        <ProductGrid :products="filtered" />   

    </div> </main>
  </AppLayout>
</template>
