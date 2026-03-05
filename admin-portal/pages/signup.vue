<template>
  <AuthPageWrapper title="Sign up" action-label="Login" action-to="/login">
    <h2 class="auth-title">Create your Account</h2>

    <form class="auth-card" @submit.prevent="handleSignup">
      <div class="auth-field">
        <label class="auth-field__label">user_name</label>
        <input v-model="form.name" type="text" class="auth-field__input" required />
      </div>

      <div class="auth-field">
        <label class="auth-field__label">mail_adress</label>
        <input v-model="form.email" type="email" class="auth-field__input" required />
      </div>

      <div class="auth-field">
        <label class="auth-field__label">password</label>
        <input v-model="form.password" type="password" class="auth-field__input" required />
      </div>

      <div class="auth-field">
        <label class="auth-field__label">confirm password</label>
        <input v-model="form.confirmPassword" type="password" class="auth-field__input" required />
      </div>

      <p v-if="error" class="auth-error">{{ error }}</p>

      <button type="submit" class="auth-btn" :disabled="loading">
        {{ loading ? '処理中...' : 'Sign up' }}
      </button>
    </form>
  </AuthPageWrapper>
</template>

<script setup lang="ts">
import { useMutation } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

definePageMeta({ layout: false })

const REGISTER_MUTATION = gql`
  mutation Register($name: String!, $email: String!, $password: String!) {
    register(name: $name, email: $email, password: $password) {
      token
      user { id name email role }
    }
  }
`

const { setAuth } = useAuth()
const form = reactive({ name: '', email: '', password: '', confirmPassword: '' })
const error = ref('')

const { mutate: registerMutation, loading } = useMutation(REGISTER_MUTATION)

async function handleSignup() {
  error.value = ''

  if (form.password !== form.confirmPassword) {
    error.value = 'パスワードが一致しません。'
    return
  }

  try {
    const result = await registerMutation({ name: form.name, email: form.email, password: form.password })
    const { token, user } = result!.data!.register
    setAuth(token, { id: user.id, name: user.name, email: user.email, role: user.role })
    navigateTo('/')
  } catch {
    error.value = '登録に失敗しました。メールアドレスが既に使用されている可能性があります。'
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

.auth-btn {
  width: 200px;
  padding: 10px;
  margin-top: 24px;
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

.auth-error {
  font-size: 13px;
  color: $danger;
  text-align: center;
  margin: 8px 0 0;
}
</style>
