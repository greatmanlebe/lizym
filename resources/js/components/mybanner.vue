<template>
  <section class="hero">
    <div class="container">
      <h2>Welcome to ShopHub</h2>
      <p>Discover amazing products at unbeatable prices</p>

      <div class="hero-buttons">
        <Link href="/shop" class="btn btn-primary">Shop Now</Link>
        <button class="btn btn-outline">Learn More</button>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
</script>