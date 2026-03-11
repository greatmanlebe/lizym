<script setup>
import { usePage, Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import AppLayout from '@/layouts/main.vue'
const { t } = useI18n()

// Always safe
const sellers = usePage().props.sellers ?? []
</script>

<template>
  <AppLayout>
  <div class="container">
    <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 1.5rem;">
      {{ t('sellers.title') }}
    </h1>

    <div class="products-grid">
        <div
          v-for="seller in sellers"
          :key="seller.id"
          class="product-card"
        >
          <div class="product-info">
            <h2 class="product-name">
              {{ seller.name }}
            </h2>
            <p  class="product-name">
              {{ t('sellers.email') }}: {{ seller.email }}
            </p>
            <p style="color: #6b7280; margin-bottom: .25rem;">
              {{ t('sellers.products') }}: {{ seller.products_count }}
            </p>
            <p style="color: #6b7280; margin-bottom: 1rem;">
              {{ t('sellers.certification') }}:
              <strong>{{ seller.certification_status }}</strong>
            </p>
          </div>
            <Link
              :href="`/admin/sellers/${seller.slug}`"
              class="add-to-cart"
              style="width: 100%; text-align: center;"
            >
              {{ t('sellers.view_profile') }}
            </Link>
      </div>
    </div>

    <p v-if="sellers.length === 0" style="margin-top: 2rem; color: #777;">
      {{ t('sellers.no_sellers') }}
    </p>


  </div>
    </AppLayout>
</template>