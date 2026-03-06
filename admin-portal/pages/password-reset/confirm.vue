<template>
  <AuthPageWrapper title="Reset Password" action-label="Login" action-to="/login">
    <h2 class="auth-title">New Password</h2>

    <div v-if="done" class="auth-card auth-card--message">
      <p>パスワードを変更しました。</p>
      <NuxtLink to="/login" class="auth-link">ログイン画面へ</NuxtLink>
    </div>

    <div v-else-if="!email || !token" class="auth-card auth-card--message">
      <p>無効なリンクです。</p>
      <NuxtLink to="/password-reset" class="auth-link">再度リセットを申請する</NuxtLink>
    </div>

    <form v-else class="auth-card" @submit.prevent="handleReset">
      <div class="auth-field">
        <label class="auth-field__label">新しいパスワード</label>
        <input v-model="form.password" type="password" class="auth-field__input" required />
      </div>
      <div class="auth-field">
        <label class="auth-field__label">パスワード（確認）</label>
        <input v-model="form.confirmPassword" type="password" class="auth-field__input" required />
      </div>

      <p v-if="error" class="auth-error">{{ error }}</p>

      <button type="submit" class="auth-btn" :disabled="loading">
        {{ loading ? '処理中...' : 'パスワードを変更する' }}
      </button>
    </form>
  </AuthPageWrapper>
</template>

<script setup lang="ts">
import { useMutation } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

definePageMeta({ layout: false })

const RESET_PASSWORD = gql`
  mutation ResetPassword($email: String!, $token: String!, $password: String!) {
    resetPassword(email: $email, token: $token, password: $password)
  }
`

const route = useRoute()
const email = computed(() => String(route.query.email ?? ''))
const token = computed(() => String(route.query.token ?? ''))

const { mutate: resetPassword, loading } = useMutation(RESET_PASSWORD)
const form = reactive({ password: '', confirmPassword: '' })
const error = ref('')
const done = ref(false)

async function handleReset() {
  error.value = ''

  if (form.password !== form.confirmPassword) {
    error.value = 'パスワードが一致しません。'
    return
  }

  try {
    await resetPassword({ email: email.value, token: token.value, password: form.password })
    done.value = true
  } catch (e: any) {
    error.value = 'パスワードの変更に失敗しました。リンクが無効または期限切れの可能性があります。'
  }
}
</script>

<style lang="scss" scoped>
.auth-title {
  font-size: 26px;
  font-weight: bold;
  color: $primary;
  margin-bottom: 20px;
  text-align: center;
}

.auth-card {
  width: 400px;
  background-color: #efefef;
  padding: 32px 40px 36px;
  display: flex;
  flex-direction: column;
  align-items: center;

  &--message {
    text-align: center;
    line-height: 1.8;
    gap: 20px;
  }
}

.auth-field {
  width: 100%;
  margin-bottom: 16px;

  &__label {
    display: block;
    font-size: 13px;
    color: $text-muted;
    margin-bottom: 6px;
    text-align: center;
  }

  &__input {
    width: 100%;
    padding: 8px 10px;
    border: 1px solid #ccc;
    background-color: #fff;
    font-size: 15px;
    box-sizing: border-box;

    &:focus {
      outline: none;
      border-color: $primary;
    }
  }
}

.auth-error {
  font-size: 13px;
  color: $danger;
  text-align: center;
  margin: 8px 0 0;
}

.auth-btn {
  width: 200px;
  padding: 10px;
  margin-top: 20px;
  background-color: rgba($primary, 0.5);
  color: #fff;
  font-size: 16px;
  font-weight: bold;
  border: none;
  cursor: pointer;
  transition: background-color 0.15s;

  &:hover:not(:disabled) {
    background-color: rgba($primary, 0.65);
  }

  &:disabled {
    opacity: 0.6;
    cursor: not-allowed;
  }
}

.auth-link {
  font-size: 14px;
  color: $primary;
  text-decoration: none;

  &:hover {
    text-decoration: underline;
  }
}
</style>
