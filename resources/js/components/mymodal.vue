<script setup lang="ts">
import type { Product } from '../types/Product'
import { useCart } from '../composables/usercart'

const props = defineProps<{
  open: boolean
  product: Product | null
}>()

defineEmits(['close'])

const { add } = useCart()
</script>

<template>
  <div class="modal" :class="{ active: open }">
    <div class="modal-content">
      <button class="close-modal" @click="$emit('close')">×</button>

      <div class="modal-body" v-if="product">
        <div style="display: grid; gap: 1.5rem;">
          
          <img 
            :src="product.image" 
            style="width: 100%; border-radius: 0.5rem;" 
          />

          <div>
            <h2 style="font-size: 2rem; margin: 0.5rem 0;">
              {{ product.name }}
            </h2>

            <p style="color: #4b5563; line-height: 1.6;">
              {{ product.description }}
            </p>

            <div style="font-size: 2rem; color: #111827; margin: 1rem 0;">
              ${{ product.price }}
            </div>

            <button class="btn btn-primary" @click="add(product)">
              Add to Cart
            </button>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>