<script setup lang="ts">
import { useCart } from '../composables/usercart'

defineProps<{ open: boolean }>()
defineEmits(['close'])

const { cart, update, remove } = useCart()
</script>

<template>
  <div class="cart-sidebar" :class="{ active: open }">
    <div class="cart-header">
      <h3>Shopping Cart</h3>
      <button class="close-cart" @click="$emit('close')">×</button>
    </div>

    <div class="cart-items">
      <div v-for="item in cart" :key="item.product.id" class="cart-item">
        <img :src="item.product.image" />

        <div class="cart-item-info">
          <h4>{{ item.product.name }}</h4>
          <div class="cart-item-price">${{ item.product.price }}</div>

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

      <button class="btn btn-primary checkout-btn">Checkout</button>
    </div>
  </div>
</template>