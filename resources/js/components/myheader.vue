<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'
const { count } = useCart()
import { useCart } from '../composables/usercart'

const mobileMenu = ref(false)
defineEmits(['open-cart'])

// buyer info 
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()

const buyer = computed(() => page.props.auth?.buyer ?? null)



</script>

<template>
  <header class="header">
    <div class="container">
      <div class="header-content">
        <h1 class="logo">ShopHub</h1>

        <nav class="desktop-nav">
          <Link href="/home">Home</Link>
          <Link href="/">Shop</Link>
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
            <Link href="/login">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M12 4h7v16h-7"/>
                <path d="M12 12H3"/>
                <path d="M7 8l-4 4 4 4"/>
              </svg>


            </Link>

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
        <Link href="/home">Home</Link>
        <Link href="/">Shop</Link>
        <Link href="/categories">Categories</Link>
        <Link href="/about">About</Link>
        <Link href="/contact">Contact</Link>
       <div v-if="buyer" style="font-weight:600; margin-left:1rem;">
    <p>Welcome {{ buyer.name }} (ID: {{ buyer.id }})</p>

</div>

      </div>
    </div>
  </header>
</template>
