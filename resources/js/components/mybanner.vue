<template>
  <section class="hero">
    <div class="container">
      <h2>{{ $t('app.Welcome to Lizym') }}</h2>
      <p>{{ $t('app.text') }}</p>

      <div class="hero-buttons">
        <Link href="/seller/register" class="btn btn-primary">{{ $t('app.Become a partner') }}</Link>
        <button class="btn btn-outline">{{ $t('app.learn more') }}</button>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
</script>