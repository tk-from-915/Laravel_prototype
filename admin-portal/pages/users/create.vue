<template>
  <div class="user-settings">
    <h1 class="page-title">ユーザ 新規作成</h1>

    <form class="user-settings__form" @submit.prevent="handleCreate">
      <div class="settings-field">
        <label class="settings-field__label">ニックネーム</label>
        <input
          v-model="form.name"
          type="text"
          class="settings-field__input settings-field__input--short"
          required
        />
      </div>

      <div class="settings-field">
        <label class="settings-field__label">登録メールアドレス</label>
        <input
          v-model="form.email"
          type="email"
          class="settings-field__input settings-field__input--wide"
          required
        />
      </div>

      <div class="settings-field">
        <label class="settings-field__label">パスワード</label>
        <input
          v-model="form.password"
          type="password"
          class="settings-field__input settings-field__input--short"
          required
        />
      </div>

      <div class="settings-field">
        <label class="settings-field__label">パスワード確認</label>
        <input
          v-model="form.confirmPassword"
          type="password"
          class="settings-field__input settings-field__input--short"
          required
        />
      </div>

      <div class="settings-field">
        <label class="settings-field__label">権限</label>
        <select v-model="form.role" class="settings-field__input settings-field__input--short" required>
          <option value="admin">管理者</option>
          <option value="viewer">閲覧者</option>
        </select>
      </div>

      <p v-if="error" class="form-error">{{ error }}</p>

      <div class="user-settings__actions">
        <button type="button" class="btn btn-secondary btn-sm" @click="navigateTo('/users')">
          キャンセル
        </button>
        <button type="submit" class="save-btn" :disabled="saving">
          {{ saving ? '処理中...' : 'save' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { useMutation } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const REGISTER = gql`
  mutation Register($name: String!, $email: String!, $password: String!) {
    register(name: $name, email: $email, password: $password) {
      user { id }
    }
  }
`

const UPDATE_USER = gql`
  mutation UpdateUser($id: ID!, $role: String) {
    updateUser(id: $id, role: $role) { id }
  }
`

const form = reactive({
  name: '',
  email: '',
  password: '',
  confirmPassword: '',
  role: 'viewer' as 'admin' | 'viewer',
})

const error = ref('')
const saving = ref(false)

const { mutate: registerMutation } = useMutation(REGISTER)
const { mutate: updateUser } = useMutation(UPDATE_USER)

async function handleCreate() {
  error.value = ''

  if (form.password !== form.confirmPassword) {
    error.value = 'パスワードが一致しません。'
    return
  }

  saving.value = true
  try {
    const result = await registerMutation({ name: form.name, email: form.email, password: form.password })
    const newUserId = result?.data?.register?.user?.id

    if (newUserId && form.role !== 'viewer') {
      await updateUser({ id: newUserId, role: form.role })
    }

    await navigateTo('/users')
  } catch {
    error.value = '作成に失敗しました。メールアドレスが既に使用されている可能性があります。'
  } finally {
    saving.value = false
  }
}
</script>

<style lang="scss" scoped>
.user-settings {
  max-width: 700px;

  &__form {
    margin-top: 32px;
  }

  &__actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 32px;
  }
}

.settings-field {
  margin-bottom: 28px;

  &__label {
    display: block;
    font-size: 14px;
    color: $text-muted;
    margin-bottom: 8px;
  }

  &__input {
    padding: 9px 12px;
    border: 1px solid $border;
    font-size: 15px;
    background-color: #fff;
    display: block;

    &--short { width: 320px; }
    &--wide  { width: 100%; max-width: 580px; }

    &:focus {
      outline: none;
      border-color: $primary;
    }
  }
}

.form-error {
  font-size: 13px;
  color: $danger;
  margin: -12px 0 16px;
}

.save-btn {
  padding: 10px 48px;
  background-color: rgba($primary, 0.5);
  color: #fff;
  font-size: 16px;
  font-weight: bold;
  border: none;
  cursor: pointer;
  letter-spacing: 1px;
  transition: background-color 0.15s;

  &:hover:not(:disabled) {
    background-color: rgba($primary, 0.65);
  }

  &:disabled {
    opacity: 0.6;
    cursor: not-allowed;
  }
}
</style>
