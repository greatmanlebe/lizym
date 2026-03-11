<script setup>
import { usePage } from '@inertiajs/vue3'
import AppLayout from '@/layouts/main.vue'

const page = usePage()
const seller = page.props.auth.seller
const products = page.props.products
const csrf = page.props.csrf_token
</script>

<template>
  <AppLayout>

    <main class="dashboard-container">

      <!-- Header -->
      <section class="dashboard-header">
        <h1 class="dashboard-title">{{ $t('app.wel') }} {{ seller.name }}</h1>
        <!--<p class="dashboard-subtitle">Seller ID: {{ seller.id }}</p> -->
        <h2 class="dashboard-text">{{ $t('app.statue') }} ; {{ seller.certification_status }}</h2>
        <a href="/seller/products/create" class="btn-primary add-product-btn">
          {{ $t('app.+ Add Product') }}
        </a>
        <br>
        <a href="/seller/documents" class="btn-primary add-product-btn">
          {{ $t('app.+ verify') }}
        </a>
      </section>

      <!-- Product List -->
      <section class="products-section">
        <h2 class="section-title">{{ $t('app.Your Products') }}</h2>

        <div v-if="products.length === 0" class="empty-state">
          <p>{{ $t('app.You have no products yet') }}</p>
        </div>

        <div v-else class="products-grid">
          <div
            v-for="product in products"
            :key="product.id"
            class="product-card"
          >
           <img :src="`/img/${product.image}`"               alt="Product Image"
              class="product-image" />
            <div class="product-info">
              <h3 class="product-name">{{ product.name }}</h3>
              <p class="product-price">FCFA {{ product.price }}</p>
              <p class="product-category">Category: {{ product.category }}</p>
            </div>

            <form
              :action="`/seller/products/${product.id}`"
              method="POST"
              class="delete-form"
            >
              <input type="hidden" name="_token" :value="csrf" />
              <input type="hidden" name="_method" value="DELETE" />

              <button class="btn-danger delete-btn">
               {{ $t('app.delete') }}
              </button>
            </form>
          </div>
        </div>
      </section>
      <br>
      <a :href="`/shop/${seller.slug}`" class="btn-primary">
       {{ $t('app.View My Shop') }}
      </a>

    </main>

  </AppLayout>
</template>

<style scoped>
/* Main container */
.dashboard-container {
  max-width: 1100px;
  margin: 40px auto;
  padding: 20px;
}

/* Header */
.dashboard-header {
  text-align: center;
  margin-bottom: 40px;
}

.dashboard-title {
  font-size: 32px;
  font-weight: 700;
}

.dashboard-subtitle {
  font-size: 16px;
  color: #666;
  margin-bottom: 20px;
}

.add-product-btn {
  margin-top: 15px;
}

/* Section title */
.section-title {
  font-size: 24px;
  font-weight: 700;
  margin-bottom: 20px;
}

/* Empty state */
.empty-state {
  text-align: center;
  padding: 40px;
  background: #fafafa;
  border-radius: 12px;
  border: 1px solid #eee;
}

/* Product grid */
.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 20px;
}

/* Product card */
.product-card {
  background: #fff;
  border-radius: 12px;
  padding: 15px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.06);
  border: 1px solid #eee;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.product-image {
  width: 100%;
  height: 180px;
  object-fit: cover;
  border-radius: 10px;
}

.product-info {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.product-name {
  font-size: 18px;
  font-weight: 600;
}

.product-price {
  font-size: 16px;
  color: #4a90e2;
  font-weight: 600;
}

.product-category {
  font-size: 14px;
  color: #777;
}

/* Delete button */
.delete-form {
  margin-top: auto;
}

.btn-danger {
  background: #e74c3c;
  color: white;
  padding: 10px;
  width: 100%;
  border: none;
  border-radius: 8px;
  font-size: 15px;
  cursor: pointer;
  transition: 0.2s;
}

.btn-danger:hover {
  background: #c0392b;
}

/* Primary button */
.btn-primary {
  background: #4a90e2;
  color: white;
  padding: 12px 18px;
  border-radius: 8px;
  font-size: 16px;
  text-decoration: none;
  display: inline-block;
  transition: 0.2s;
}

.btn-primary:hover {
  background: #357ABD;
}
</style>