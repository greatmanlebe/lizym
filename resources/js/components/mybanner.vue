<template>
  <section class="hero">
    <div class="container">
      <h2>Welcome to Lizym</h2>
      <p>Discover amazing products at unbeatable prices</p>

      <div class="hero-buttons">
        <Link href="/seller/register" class="btn btn-primary">Sell</Link>
        <button class="btn btn-outline">Learn More</button>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
</script>