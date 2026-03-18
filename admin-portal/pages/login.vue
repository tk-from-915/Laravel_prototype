<template>
  <AuthPageWrapper title="Login" action-label="Sign up" action-to="/signup">
    <h2 class="auth-title">Login</h2>

    <form class="auth-card" @submit.prevent="handleLogin">
      <div class="auth-field">
        <label class="auth-field__label">user_name</label>
        <input v-model="form.username" type="text" class="auth-field__input" />
      </div>

      <p class="auth-or">or<br />mail_adress</p>

      <div class="auth-field">
        <input v-model="form.email" type="email" class="auth-field__input" />
      </div>

      <div class="auth-field">
        <label class="auth-field__label">password</label>
        <input v-model="form.password" type="password" class="auth-field__input" required />
      </div>

      <p v-if="error" class="auth-error">{{ error }}</p>

      <button type="submit" class="auth-btn" :disabled="loading">
        {{ loading ? '処理中...' : 'Login' }}
      </button>

      <NuxtLink to="/password-reset" class="auth-link">パスワードを忘れた時は</NuxtLink>
    </form>
  </AuthPageWrapper>
</template>

<script setup lang="ts">
import { useMutation } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

definePageMeta({ layout: false })

const LOGIN_MUTATION = gql`
  mutation Login($email: String!, $password: String!) {
    login(email: $email, password: $password) {
      token
      user { id name email role }
    }
  }
`

const { setAuth } = useAuth()
const form = reactive({ username: '', email: '', password: '' })
const error = ref('')

const { mutate: loginMutation, loading } = useMutation(LOGIN_MUTATION)

async function handleLogin() {
  error.value = ''
  // username フィールドにメールアドレスを入力した場合も受け付ける
  const email = form.email || form.username

  try {
    const result = await loginMutation({ email, password: form.password })
    const { token, user } = result!.data!.login
    setAuth(token, { id: user.id, name: user.name, email: user.email, role: user.role })
    navigateTo('/')
  } catch {
    error.value = 'メールアドレスまたはパスワードが正しくありません。'
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

.auth-or {
  font-size: 13px;
  color: $text-muted;
  text-align: center;
  margin: 0 0 6px;
  line-height: 1.4;
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
  font-size: 18px;
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
  margin-top: 20px;
  font-size: 14px;
  color: $primary;
  text-decoration: none;

  &:hover {
    text-decoration: underline;
  }
}
</style>
