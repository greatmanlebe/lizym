<script setup lang="ts">
import { useCart } from '../composables/usercart'
import { useForm } from '@inertiajs/vue3'

defineProps<{ open: boolean }>()
defineEmits(['close'])

const { cart, update, remove, clear } = useCart()

const form = useForm({
  grouped_cart: {}
})

function startChat() {
  if (!cart.value.length) return

  const grouped: Record<number, any[]> = {}

  cart.value.forEach(item => {
    const sellerId = item.product.seller_id

    if (!grouped[sellerId]) grouped[sellerId] = []

    grouped[sellerId].push({
      id: item.product.id,
      name: item.product.name,
      quantity: item.quantity,
      price: item.product.price,
      seller_id: sellerId
    })
  })

  form.grouped_cart = grouped

  form.post('/checkout/start-chat', {
    onSuccess: () => {
      clear()          // 🟩 Empty the cart
      emit('close')    // 🟩 Close the sidebar
    }
  })
}
</script>

<template>
  <div class="cart-sidebar" :class="{ active: open }">
    <div class="cart-header">
      <h3>{{ $t('app.cart') }}</h3>
      <button class="close-cart" @click="$emit('close')">×</button>
    </div>

    <div class="cart-items">
      <div v-for="item in cart" :key="item.product.id" class="cart-item">
           <img :src="`/img/${item.product.image}`"               alt="Product Image"
              class="product-image" />
        <div class="cart-item-info">
          <h4>{{ item.product.name }}</h4>
          <div class="cart-item-price">FCFA {{ item.product.price }}</div>

          <div class="cart-item-actions">
            <button class="quantity-btn" @click="update(item.product.id, -1)">-</button>
            <span>{{ item.quantity }}</span>
            <button class="quantity-btn" @click="update(item.product.id, 1)">+</button>
            <button class="quantity-btn" @click="remove(item.product.id)">×</button>
          </div>
        </div>
      </div>
    </div>

    <div class="cart-footer">
      <div class="cart-total">
        <span>Total:</span>
        <span>
          ${{ cart.reduce((s, i) => s + i.product.price * i.quantity, 0).toFixed(2) }}
        </span>
      </div>

      <button class="btn btn-primary checkout-btn" @click="startChat">{{ $t('app.checkout') }}</button>
    </div>
  </div>
</template>