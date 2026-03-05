<template>
  <section class="hero">
    <div class="container">
      <h2>{{ $t('app.Welcome to Lizym') }}</h2>
      <p>{{ seller.slug }} {{ $t('app.shop') }}</p>

    </div>
  </section>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'
const page = usePage()
//const seller = page.props.seller
const seller = usePage().props.auth.seller

</script>