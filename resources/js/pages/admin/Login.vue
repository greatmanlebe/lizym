<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/main.vue'
const form = useForm({
  email: '',
  password: '',
})

const showPassword = ref(false)

const submit = () => {
  form.post('/admin/login')
}
</script>

<template>
  <AppLayout>
  <div  class="container" style="max-width: 450px; padding: 2rem 1rem;">
    <div
      class="w-full max-w-md bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 animate-fadeIn"
      style="animation-duration: 0.6s"
    >
      <h1 class="text-2xl font-bold text-center mb-6 text-gray-800 dark:text-gray-100">
        {{ $t('admin.login.title') }}
      </h1>

      <!-- Errors -->
      <div v-if="form.errors.email" class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        {{ form.errors.email }}
      </div>

      <form @submit.prevent="submit" class="space-y-5">
        <!-- Email -->
        <div>
          <label class="block text-gray-700 dark:text-gray-300 mb-1">
            {{ $t('admin.login.email') }}
          </label>
          <input
            v-model="form.email"
            type="email"
            class="input"
            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;"
            :placeholder="$t('admin.login.email_placeholder')"
          />
        </div>

        <!-- Password -->
        <div>
          <label class="block text-gray-700 dark:text-gray-300 mb-1">
            {{ $t('admin.login.password') }}
          </label>

          <div class="relative">
            <input
              v-model="form.password"
              :type="showPassword ? 'text' : 'password'"
            class="input"
            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;"
              :placeholder="$t('admin.login.password_placeholder')"
            />

            <!-- Show/Hide Button -->
            <button
              type="button"
              @click="showPassword = !showPassword"
              class="btn btn-primary"
            >
              <span v-if="showPassword">👁️</span>
              <span v-else>👁️‍🗨️</span>
            </button>
          </div>
        </div>

        <!-- Submit -->
        <button
          type="submit"
          class="btn btn-primary"
          :disabled="form.processing"
        >
          <span v-if="!form.processing">{{ $t('admin.login.button') }}</span>
          <span v-else>{{ $t('admin.login.processing') }}</span>
        </button>
      </form>
    </div>
  </div></AppLayout>
</template>

<style>
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to   { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
  animation: fadeIn 0.5s ease-out forwards;
}
</style>