<template>
  <AuthPageWrapper title=":Reset Password page" action-label="Login" action-to="/login">
    <h2 class="auth-title">Reset Password</h2>

    <div v-if="sent" class="auth-card auth-card--message">
      <p>パスワードリセットのリンクをメールで送信しました。</p>
      <NuxtLink to="/login" class="auth-link">ログイン画面へ戻る</NuxtLink>
    </div>

    <form v-else class="auth-card" @submit.prevent="handleReset">
      <div class="auth-field">
        <label class="auth-field__label">E-Mail Address</label>
        <input v-model="email" type="email" class="auth-field__input" required />
      </div>

      <p v-if="error" class="auth-error">{{ error }}</p>

      <button type="submit" class="auth-btn" :disabled="loading">
        {{ loading ? '送信中...' : 'Send Password\nReset Link' }}
      </button>
    </form>
  </AuthPageWrapper>
</template>

<script setup lang="ts">
import { useMutation } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

definePageMeta({ layout: false })

const FORGOT_PASSWORD = gql`
  mutation ForgotPassword($email: String!) {
    forgotPassword(email: $email)
  }
`

const { mutate: forgotPassword, loading } = useMutation(FORGOT_PASSWORD)

const email = ref('')
const sent = ref(false)
const error = ref('')

async function handleReset() {
  error.value = ''
  try {
    await forgotPassword({ email: email.value })
    sent.value = true
  } catch (e: any) {
    error.value = 'エラーが発生しました。しばらくしてから再度お試しください。'
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
    gap: 16px;
  }
}

.auth-field {
  width: 100%;
  margin-bottom: 24px;

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

.auth-btn {
  width: 200px;
  height: 140px;
  background-color: rgba($primary, 0.5);
  color: #fff;
  font-size: 18px;
  font-weight: bold;
  line-height: 1.5;
  border: none;
  cursor: pointer;
  transition: background-color 0.15s;
  text-align: center;

  &:hover:not(:disabled) {
    background-color: rgba($primary, 0.65);
  }

  &:disabled {
    opacity: 0.6;
    cursor: not-allowed;
  }
}

.auth-error {
  font-size: 13px;
  color: $danger;
  text-align: center;
  margin: 0 0 8px;
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
