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

      <div class="user-settings__actions">
        <button type="button" class="btn btn-secondary btn-sm" @click="navigateTo('/users')">
          キャンセル
        </button>
        <button type="submit" class="save-btn">save</button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
const form = reactive({
  name: '',
  email: '',
  password: '',
  confirmPassword: '',
  role: 'viewer' as 'admin' | 'viewer',
})

async function handleCreate() {
  // TODO: GraphQL mutation でユーザー作成処理を実装
  console.log('create user:', form)
  await navigateTo('/users')
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

  &:hover {
    background-color: rgba($primary, 0.65);
  }
}
</style>
