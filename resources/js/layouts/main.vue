<script setup lang="ts">
import Header from '../components/myheader.vue'
import CartSidebar from '../components/mycard.vue'
import ProductModal from '../components/mymodal.vue'
import Footer from '../components/myfooter.vue'


import { ref, onMounted } from 'vue'
import type { Product } from '../types/Product'

const cartOpen = ref(false)
const modalOpen = ref(false)          // must be boolean, not null
const modalProduct = ref<Product | null>(null)

function openCart() {
  cartOpen.value = true
}

function closeCart() {
  cartOpen.value = false
}

// ❌ cannot be named modalOpen
// ✔ rename to openModal
function openModal(product: Product) {
  modalProduct.value = product
  modalOpen.value = true
}

function closeModal() {
  modalOpen.value = false
}

// Listen for global event from ProductCard.vue
onMounted(() => {
  window.addEventListener('open-modal', (e: any) => {
    openModal(e.detail)
  })
})
</script>

<template>
  <div>
    <Header @open-cart="openCart" />

    <main>
      <slot />
    </main>

    <CartSidebar :open="cartOpen" @close="closeCart" />
    <ProductModal :open="modalOpen" :product="modalProduct" @close="closeModal" />

    <Footer />
  </div>
</template>

