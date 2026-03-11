<script setup>
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/main.vue'
import { ref } from 'vue'
const showPassword = ref(false)

const form = useForm({
  name: '',
  email: '',
  password: '',
    number: '',
        slug: '',
      location: '',
})
function submit() {
  form.post('/seller/register')
}
</script>

<template>
  <AppLayout>
    <div class="container" style="max-width: 450px; padding: 2rem 1rem;">
      <h2 style="font-size: 2rem; margin-bottom: 1rem; text-align:center;">{{ $t('app.create') }}</h2>

      <form @submit.prevent="submit" style="display: grid; gap: 1.2rem;">
        
        <div>
          <label style="font-weight: 600;">{{ $t('app.name') }}</label>
          <input
            v-model="form.name"
            type="text"
            required
            class="input"
            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;"
          />
        </div>
        <div>
          <label style="font-weight: 600;">{{ $t('app.slug') }}</label>
          <input
            v-model="form.slug"
            type="text"
            required
            class="input"
            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;"
          />
                    <div v-if="form.errors.slug" class="error">{{ $t('validation.slug_taken') }}</div>
        </div>
        <div>
          <label style="font-weight: 600;">Email</label>
          <input
            v-model="form.email"
            type="email"
            required
            class="input"
            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;"
          />
          <div v-if="form.errors.email" class="error">{{ $t('validation.email_taken') }}</div>
        </div>

        <div>
          <label style="font-weight: 600;">{{ $t('app.password') }}</label>
          <input
            v-model="form.password"
             :type="showPassword ? 'text' : 'password'"
              @click="showPassword = !showPassword"
            required
            class="input"
            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;"
          />
                    <div v-if="form.errors.email" class="error">{{ $t('validation.pass_taken') }}</div>
        </div>
        <div>
          <label style="font-weight: 600;">{{ $t('app.location') }}</label>
          <input
            v-model="form.location"
            type="text"
            required
            class="input"
            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;"
          />
        </div>
        <div>
          <label style="font-weight: 600;">{{ $t('app.tel') }}</label>
          <input
            v-model="form.number"
            type="interger"
            required
            class="input"
            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;"
          />
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.9rem;">
          {{ $t('app.register') }}
        </button>

        <p style="text-align:center; margin-top: 0.5rem;">
          {{ $t('app.already have an account') }}
          <a href="/seller/login" style="color: #2563eb; font-weight: 600;">{{ $t('app.login') }}</a>
        </p>
      </form>
    </div>
  </AppLayout>
</template>

<style>
.auth-container { max-width: 400px; margin: auto; }
.error {
  color: red;
  font-size: 14px;
  margin-top: 4px;
}

</style>