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
//for popup msg
import { usePage } from '@inertiajs/vue3'
import { watch } from 'vue'

const page = usePage()
const message = ref(page.props.message)

watch(
  () => page.props.message,
  (val) => {
    if (val) {
      message.value = val
      setTimeout(() => message.value = null, 2500)
    }
  }
)



</script>

<template>
  <div>
    <Header @open-cart="openCart" />

    <main>
      <slot />
    </main>

    <CartSidebar :open="cartOpen" @close="closeCart" />
    <ProductModal :open="modalOpen" :product="modalProduct" @close="closeModal" />
    <div v-if="message" class="popup">
      {{ message }}
    </div>
    <div v-if="message" class="popup">
      {{ message }}
    </div>

    <Footer />
  </div>
</template>

<style scoped>
.popup {
  position: fixed;
  top: 20px;
  right: 20px;
  background: #4a90e2;
  color: white;
  padding: 14px 20px;
  border-radius: 10px;
  font-size: 15px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.15);
  z-index: 9999;
  animation: fadeInOut 2.5s ease forwards;
}

@keyframes fadeInOut {
  0% { opacity: 0; transform: translateY(-10px); }
  10% { opacity: 1; transform: translateY(0); }
  90% { opacity: 1; }
  100% { opacity: 0; transform: translateY(-10px); }
}
</style>

