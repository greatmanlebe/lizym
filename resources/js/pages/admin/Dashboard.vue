<script setup>
import { onMounted, ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import Chart from 'chart.js/auto'
import { useI18n } from 'vue-i18n'
import AppLayout from '@/layouts/main.vue'
const { t } = useI18n()
const stats = usePage().props.stats
import { Link } from '@inertiajs/vue3'
const sellerGrowthChart = ref(null)
const certificationChart = ref(null)
   



onMounted(() => {
  new Chart(sellerGrowthChart.value, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
        label: t('dashboard.seller_growth'),
        data: [5, 12, 20, 30, 45, stats.totalSellers],
        borderColor: '#2563eb',
        backgroundColor: 'rgba(37, 99, 235, 0.3)',
        tension: 0.3
      }]
    }
  })

  new Chart(certificationChart.value, {
    type: 'pie',
    data: {
      labels: [
        t('dashboard.pending'),
        t('dashboard.verified'),
        t('dashboard.gold'),
        t('dashboard.platinum'),
        t('dashboard.rejected')
      ],
      datasets: [{
        data: [
          stats.pendingCerts,
          stats.verifiedSellers,
          stats.goldSellers,
          stats.platinumSellers,
          stats.rejectedSellers
        ],
        backgroundColor: [
          '#fbbf24',
          '#10b981',
          '#f59e0b',
          '#6366f1',
          '#ef4444'
        ]
      }]
    }
  })
})
</script>

<template>
    
  <div class="container">
    <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 1.5rem;">
      {{ t('dashboard.title') }}
    </h1>

    <!-- Stats Cards -->
    <div class="products-grid">
    
        <Link
        href="/admin/sellers"
        class="product-card"
        style="padding: 1.5rem; display: block; cursor: pointer;"
        >
        {{ t('dashboard.total_sellers') }}: {{ stats.totalSellers }}
        </Link>


      <div class="product-card" style="padding: 1.5rem;">
        {{ t('dashboard.pending_certifications') }}: {{ stats.pendingCerts }}
      </div>

      <div class="product-card" style="padding: 1.5rem;">
        {{ t('dashboard.verified_sellers') }}: {{ stats.verifiedSellers }}
      </div>

      <div class="product-card" style="padding: 1.5rem;">
        {{ t('dashboard.gold_sellers') }}: {{ stats.goldSellers }}
      </div>

      <div class="product-card" style="padding: 1.5rem;">
        {{ t('dashboard.platinum_sellers') }}: {{ stats.platinumSellers }}
      </div>

      <div class="product-card" style="padding: 1.5rem;">
        {{ t('dashboard.rejected_sellers') }}: {{ stats.rejectedSellers }}
      </div>
    </div>
<br>
    <!-- Charts -->
    <div class="products-grid">
      <div class="product-card" style="padding: 1.5rem;">
        <h2 style="margin-bottom: 1rem;">{{ t('dashboard.seller_growth') }}</h2>
        <canvas ref="sellerGrowthChart"></canvas>
      </div>

      <div class="product-card" style="padding: 1.5rem;">
        <h2 style="margin-bottom: 1rem;">{{ t('dashboard.certification_distribution') }}</h2>
        <canvas ref="certificationChart"></canvas>
      </div>
    </div>

  </div>
  <br>
</template>