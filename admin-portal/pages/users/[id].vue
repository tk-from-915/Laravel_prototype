<template>
  <div v-if="loading" class="page-loading">読み込み中...</div>
  <div v-else-if="userData" class="user-settings">
    <h1 class="page-title">ユーザ設定</h1>

    <div class="user-settings__form">
      <div class="settings-field">
        <label class="settings-field__label">ニックネーム</label>
        <input
          v-if="canEdit"
          v-model="form.name"
          type="text"
          class="settings-field__input settings-field__input--short"
        />
        <span v-else class="settings-field__value">{{ form.name }}</span>
      </div>

      <div class="settings-field">
        <label class="settings-field__label">登録メールアドレス</label>
        <input
          v-if="canEdit"
          v-model="form.email"
          type="email"
          class="settings-field__input settings-field__input--wide"
        />
        <span v-else class="settings-field__value">{{ form.email }}</span>
      </div>

      <div class="settings-field">
        <label class="settings-field__label">登録パスワード</label>
        <span class="settings-field__value">••••••••••</span>
      </div>

      <div class="settings-field">
        <label class="settings-field__label">権限</label>
        <select
          v-if="canEditRole"
          v-model="form.role"
          class="settings-field__input settings-field__input--short"
        >
          <option value="admin">管理者</option>
          <option value="viewer">閲覧者</option>
        </select>
        <span v-else class="settings-field__value">
          {{ form.role === 'admin' ? '管理者' : '閲覧者' }}
        </span>
      </div>

      <div v-if="canEdit" class="user-settings__actions">
        <button type="button" class="save-btn" :disabled="saving" @click="handleSave">
          {{ saving ? '処理中...' : 'save' }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useQuery, useMutation } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const { id } = useRoute().params as { id: string }
const { currentUser, isAdmin } = useAuth()

const GET_USER = gql`
  query GetUser($id: ID!) {
    user(id: $id) { id name email role }
  }
`

const UPDATE_USER = gql`
  mutation UpdateUser($id: ID!, $name: String, $email: String, $role: String) {
    updateUser(id: $id, name: $name, email: $email, role: $role) { id }
  }
`

const { result, loading } = useQuery(GET_USER, { id }, { fetchPolicy: 'network-only' })
const userData = computed(() => result.value?.user ?? null)

const isSelf = computed(() => currentUser.value?.id === id)
const canEdit = computed(() => isAdmin.value || isSelf.value)
const canEditRole = computed(() => isAdmin.value)

const form = reactive({ name: '', email: '', role: 'viewer' as 'admin' | 'viewer' })
const saving = ref(false)

watch(userData, (val) => {
  if (!val) return
  form.name = val.name
  form.email = val.email
  form.role = val.role
}, { immediate: true })

const { mutate: updateUser } = useMutation(UPDATE_USER)

async function handleSave() {
  saving.value = true
  try {
    await updateUser({ id, name: form.name, email: form.email, role: form.role })
    await navigateTo('/users')
  } finally {
    saving.value = false
  }
}
</script>

<style lang="scss" scoped>
.page-loading {
  padding: 40px;
  text-align: center;
  color: $text-muted;
}

.user-settings {
  max-width: 700px;

  &__form {
    margin-top: 32px;
  }

  &__actions {
    display: flex;
    justify-content: flex-end;
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

  &__value {
    font-size: 15px;
    color: $text;
    padding: 9px 0;
    display: block;
  }
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
