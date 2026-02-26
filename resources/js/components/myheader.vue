<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'
const { count } = useCart()
import { useCart } from '../composables/usercart'

const mobileMenu = ref(false)
defineEmits(['open-cart'])
</script>

<template>
  <header class="header">
    <div class="container">
      <div class="header-content">
        <h1 class="logo">ShopHub</h1>

        <nav class="desktop-nav">
          <Link href="/">Home</Link>
          <Link href="/shop">Shop</Link>
          <Link href="/categories">Categories</Link>
          <Link href="/about">About</Link>
          <Link href="/contact">Contact</Link>
        </nav>

        <div class="header-actions">
            <button class="icon-btn" @click="$emit('open-cart')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>

                <span class="cart-count">{{ count }}</span>
            </button>


          <button class="icon-btn" @click="$emit('open-cart')">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <circle cx="9" cy="21" r="1"></circle>
              <circle cx="20" cy="21" r="1"></circle>
              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
          </button>

          <button class="icon-btn mobile-menu-btn" @click="mobileMenu = !mobileMenu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <line x1="3" y1="12" x2="21" y2="12"></line>
              <line x1="3" y1="6" x2="21" y2="6"></line>
              <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
          </button>
        </div>
      </div>

      <div class="mobile-menu" :class="{ active: mobileMenu }">
        <Link href="/">Home</Link>
        <Link href="/shop">Shop</Link>
        <Link href="/categories">Categories</Link>
        <Link href="/about">About</Link>
        <Link href="/contact">Contact</Link>
      </div>
    </div>
  </header>
</template>
