<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { useCart } from '../composables/usercart'

const { count } = useCart()
const mobileMenu = ref(false)
defineEmits(['open-cart'])

const page = usePage()

// Buyer and seller from Inertia shared props
const buyer = computed(() => page.props.auth?.buyer ?? null)
const seller = computed(() => page.props.auth?.seller ?? null)
</script>

<template>
  <header class="header">
    <div class="container">
      <div class="header-content">
        <h1 class="logo">LIZYM</h1>

        <nav class="desktop-nav">
          <Link href="/home">Home</Link>
          <Link href="/">Shop</Link>
          <Link href="/categories">Categories</Link>
          <Link href="/about">About</Link>
          <Link href="/contact">Contact</Link>
        </nav>

        <div class="header-actions">
          <!-- Cart -->
          <button class="icon-btn" @click="$emit('open-cart')">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <circle cx="9" cy="21" r="1"></circle>
              <circle cx="20" cy="21" r="1"></circle>
              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <span class="cart-count">{{ count }}</span>
          </button>
          <!-- Chat Button -->
          <Link href="/my-chats" class="icon-btn">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
          </Link>
          <!-- Login icon -->
          <Link href="/login">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M12 4h7v16h-7"/>
              <path d="M12 12H3"/>
              <path d="M7 8l-4 4 4 4"/>
            </svg>
          </Link>

          <!-- Mobile menu -->
          <button class="icon-btn mobile-menu-btn" @click="mobileMenu = !mobileMenu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <line x1="3" y1="12" x2="21" y2="12"></line>
              <line x1="3" y1="6" x2="21" y2="6"></line>
              <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
          </button>
        </div>
      </div>

      <!-- Mobile menu -->
      <div class="mobile-menu" :class="{ active: mobileMenu }">
        <Link href="/home">Home</Link>
        <Link href="/">Shop</Link>
        <Link href="/categories">Categories</Link>
        <Link href="/about">About</Link>
        <Link href="/contact">Contact</Link>

        <!-- Buyer -->
        <div v-if="buyer" style="font-weight:600; margin-left:1rem;">
          <p>Welcome {{ buyer.name }} (ID: {{ buyer.id }})</p>
        </div>

        <!-- Seller -->
        <div v-if="seller" style="font-weight:600; margin-left:1rem;">
          <p>Welcome {{ seller.name }} (ID: {{ seller.id }})</p>
        </div>
      </div>
    </div>
  </header>
</template>