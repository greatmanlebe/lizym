<script setup>
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/main.vue'
const categories = [
  'electronics',
  'fashion',
  'sports',
  'home',
  'accessories',
]

const form = useForm({
  name: '',
  price: '',
  image: null,
  category: '',
  description: '',
})
function handleImageUpload(e) {
  form.image = e.target.files[0]
}
function submit() {
form.post('/seller/products', {
  forceFormData: true
})

}
</script>

<template>
  <AppLayout>
    <main class="main-container">

      <section class="form-section">
        <h1 class="section-title">{{ $t('product.add_title') }}</h1>

        <form @submit.prevent="submit" class="product-form">

          <!-- Product Name -->
          <div class="form-group">
            <label class="form-label">{{ $t('product.name') }}</label>
            <input v-model="form.name" class="input-field" :placeholder="$t('product.name_placeholder')" />
          </div>

          <!-- Price -->
          <div class="form-group">
            <label class="form-label">{{ $t('product.price') }}</label>
            <input v-model="form.price" class="input-field" type="number" :placeholder="$t('product.price_placeholder')" />
          </div>

          <!-- Image URL -->
          <div class="form-group">
            <label class="form-label">{{ $t('product.image') }}</label>
             <input type="file" @change="handleImageUpload" class="input-field" />
            
          </div>

          <!-- Category -->
          <div class="form-group">
            <label class="form-label">{{ $t('product.category') }}</label>
            <select v-model="form.category" class="input-field">
              <option disabled value="">{{ $t('product.category_placeholder') }}</option>
              <option v-for="cat in categories" :key="cat" :value="cat">
                {{ $t(`categories.${cat}`) }}
              </option>
            </select>
          </div>

          <!-- Description -->
          <div class="form-group">
            <label class="form-label">{{ $t('product.description') }}</label>
            <textarea v-model="form.description" class="textarea-field" :placeholder="$t('product.description_placeholder')"></textarea>
          </div>

          <!-- Submit -->
          <button type="submit" class="btn-primary">{{ $t('product.save') }}</button>

        </form>
      </section>

    </main>
  </AppLayout>
</template>

<style scoped>
/* Uses your existing CSS structure and naming conventions */

.main-container {
  width: 100%;
  padding: 40px 20px;
  display: flex;
  justify-content: center;
}

.form-section {
  width: 100%;
  max-width: 600px;
  background: #fff;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.section-title {
  font-size: 26px;
  font-weight: 700;
  margin-bottom: 25px;
  text-align: center;
}

.product-form {
  display: flex;
  flex-direction: column;
  gap: 18px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-label {
  font-size: 15px;
  margin-bottom: 6px;
  font-weight: 600;
}

.input-field,
.textarea-field,
select {
  width: 100%;
  padding: 12px 14px;
  border-radius: 8px;
  border: 1px solid #ddd;
  font-size: 15px;
  transition: 0.2s;
}

.input-field:focus,
.textarea-field:focus,
select:focus {
  border-color: #4a90e2;
  box-shadow: 0 0 0 2px rgba(74,144,226,0.2);
  outline: none;
}

.textarea-field {
  min-height: 120px;
  resize: vertical;
}

.btn-primary {
  background: #4a90e2;
  color: white;
  padding: 14px;
  border: none;
  border-radius: 8px;
  font-size: 16px;
  cursor: pointer;
  transition: 0.2s;
  width: 100%;
}

.btn-primary:hover {
  background: #357ABD;
}
</style>

