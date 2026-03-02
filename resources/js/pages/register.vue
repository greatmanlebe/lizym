<script setup lang="ts">
import AppLayout from '../layouts/main.vue'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  name: '',
  email: '',
  number: '',
  location: '',
  password: '',

})

function submit() {
  form.post('/register')
}

</script>

<template>
  <AppLayout>
    <div class="container" style="max-width: 450px; padding: 2rem 1rem;">
      <h2 style="font-size: 2rem; margin-bottom: 1rem; text-align:center;">Create Account</h2>

      <form @submit.prevent="submit" style="display: grid; gap: 1.2rem;">
        
        <div>
          <label style="font-weight: 600;">Full Name</label>
          <input
            v-model="form.name"
            type="text"
            required
            class="input"
            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;"
          />
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
        </div>

        <div>
          <label style="font-weight: 600;">Password</label>
          <input
            v-model="form.password"
            type="password"
            required
            class="input"
            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;"
          />
        </div>

        <div>
          <label style="font-weight: 600;">location</label>
          <input
            v-model="form.location"
            type="text"
            required
            class="input"
            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;"
          />
        </div>
        <div>
          <label style="font-weight: 600;">Tel Number</label>
          <input
            v-model="form.number"
            type="interger"
            required
            class="input"
            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;"
          />
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.9rem;">
          Create Account
        </button>

        <p style="text-align:center; margin-top: 0.5rem;">
          Already have an account?
          <a href="/login" style="color: #2563eb; font-weight: 600;">Login</a>
        </p>
      </form>
    </div>
  </AppLayout>
</template>
