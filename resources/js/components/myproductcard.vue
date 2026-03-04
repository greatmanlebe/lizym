

<script setup lang="ts">
import type { Product } from '../types/Product'
import { useCart } from '../composables/usercart'

const props = defineProps<{ product: Product }>()
const { add } = useCart()

function openModal() {
  window.dispatchEvent(new CustomEvent('open-modal', { detail: props.product }))
}
</script>

<template>
  <div class="product-card">
    <div class="product-image" @click="openModal">
      <img :src="product.image" :alt="product.name" />
    </div>

    <div class="product-info">
      <span class="product-category">{{ product.category }}</span>
      <h3 class="product-name" @click="openModal">{{ product.name }}</h3>
      <span class="product-price">FCFA {{ product.price.toFixed(2) }}</span>

      <button class="add-to-cart" @click="add(product)">
       {{ $t('app.add_to_cart') }}
      </button>
    </div>
  </div>
</template>
