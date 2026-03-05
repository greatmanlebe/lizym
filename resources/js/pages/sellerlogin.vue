<template>
  <div class="auth-container">
    <div class="auth-box">

      <h1 class="auth-title">{{ $t('auth.seller_login_title') }}</h1>

      <form @submit.prevent="submit" class="auth-form">

        <!-- Email -->
        <div class="form-group">
          <label class="form-label">{{ $t('auth.email') }}</label>
          <input
            v-model="form.email"
            type="email"
            class="input-field"
            :placeholder="$t('auth.email_placeholder')"
          />
          <div v-if="form.errors.email" class="error-text">
            {{ form.errors.email }}
          </div>
        </div>

        <!-- Password -->
        <div class="form-group">
          <label class="form-label">{{ $t('auth.password') }}</label>
          <input
            v-model="form.password"
            type="password"
            class="input-field"
            :placeholder="$t('auth.password_placeholder')"
          />
          <div v-if="form.errors.password" class="error-text">
            {{ form.errors.password }}
          </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-primary">
          {{ $t('auth.login_button') }}
        </button>

        <!-- Link to register -->
        <p class="auth-switch">
          {{ $t('auth.no_account') }}
          <a href="/seller/register">{{ $t('auth.create_account') }}</a>
        </p>

      </form>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  password: '',
})

function submit() {
  form.post('/seller/login', {
    preserveScroll: true,
  })
}
</script>

<style>
.auth-container {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px 0;
}

.auth-box {
  width: 100%;
  max-width: 420px;
  background: #fff;
  padding: 32px;
  border-radius: 12px;
  box-shadow: 0 4px 14px rgba(0,0,0,0.08);
}

.auth-title {
  text-align: center;
  margin-bottom: 24px;
  font-size: 26px;
  font-weight: 700;
}

.form-group {
  margin-bottom: 18px;
}

.form-label {
  display: block;
  margin-bottom: 6px;
  font-weight: 600;
}

.input-field {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ddd;
  border-radius: 6px;
}

.btn-primary {
  width: 100%;
  padding: 12px;
  background: #111;
  color: #fff;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  margin-top: 10px;
}

.error-text {
  color: #d33;
  font-size: 14px;
  margin-top: 4px;
}

.auth-switch {
  text-align: center;
  margin-top: 16px;
}
</style>
