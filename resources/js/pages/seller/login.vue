<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  password: '',
})

function submit() {
  form.post('/seller/login')
}
</script>

<template>
  <div class="auth-container">
    <h1>Seller Login</h1>

    <form @submit.prevent="submit">
      <input v-model="form.email" type="email" placeholder="Email" />
      <input v-model="form.password" type="password" placeholder="Password" />

      <button type="submit">Login</button>

      <p v-if="form.errors.email" class="error">{{ form.errors.email }}</p>
    </form>
  </div>
</template>

<style>
.auth-container { max-width: 400px; margin: auto; }
.error { color: red; margin-top: 10px; }
</style>