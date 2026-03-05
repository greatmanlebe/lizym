<script setup>
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/main.vue'
const form = useForm({
  email: '',
  password: '',
})

function submit() {
  form.post('/seller/login')
}
</script>

<template>
<AppLayout>
    <div class="container" style="max-width: 450px; padding: 2rem 1rem;">
      <h2 style="font-size: 2rem; margin-bottom: 1rem; text-align:center;"> {{ $t('app.slogin') }}</h2>

      <form @submit.prevent="submit" style="display: grid; gap: 1.2rem;">

        <div>
          <label style="font-weight: 600;">Email</label>
          <input
            v-model="form.email"
            type="email"
            required
            class="input"
            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;"
          />
        </div>

        <div>
          <label style="font-weight: 600;">{{ $t('app.password') }}</label>
          <input
            v-model="form.password"
            type="password"
            required
            class="input"
            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;"
          />
        </div>
    <p v-if="form.errors.email" style="color:red; margin-top:10px;">
      {{ $t('validation.log_taken') }}
    </p>
        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.9rem;">
          {{ $t('app.login') }}
        </button>

        <p style="text-align:center; margin-top: 0.5rem;">
          {{ $t('app.Dont have an account') }}
          <a href="seller/register" style="color: #2563eb; font-weight: 600;">{{ $t('app.sign up') }}</a>
        </p>
      </form>



    </div>
  </AppLayout>
</template>

<style>
.auth-container { max-width: 400px; margin: auto; }
.error { color: red; margin-top: 10px; }
</style>