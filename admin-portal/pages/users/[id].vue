<template>
  <div class="user-settings">
    <h1 class="page-title">ユーザ設定</h1>

    <!-- TODO: GraphQL から id に対応するユーザーを取得する -->
    <div class="user-settings__form">
      <!-- ニックネーム -->
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

      <!-- 登録メールアドレス -->
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

      <!-- 登録パスワード -->
      <div class="settings-field">
        <label class="settings-field__label">登録パスワード</label>
        <input
          v-if="canEdit"
          v-model="form.password"
          type="password"
          class="settings-field__input settings-field__input--short"
          placeholder="変更する場合のみ入力"
        />
        <span v-else class="settings-field__value">••••••••••</span>
      </div>

      <!-- 権限 -->
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

      <!-- 保存ボタン -->
      <div v-if="canEdit" class="user-settings__actions">
        <button type="button" class="save-btn" @click="handleSave">save</button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
const { id } = useRoute().params as { id: string }
const { currentUser, isAdmin } = useAuth()

const isSelf = computed(() => currentUser.value.id === Number(id))
const canEdit = computed(() => isAdmin.value || isSelf.value)
const canEditRole = computed(() => isAdmin.value)

// TODO: GraphQL から id に対応するデータを取得する
const form = reactive({
  name:     id === '1' ? 'toki'   : id === '2' ? 'sato_f' : 'tanaka',
  email:    id === '1' ? 'aaa@email.com' : id === '2' ? 'sato@email.com' : 'tanaka@email.com',
  password: '',
  role:     id === '1' ? 'admin' : 'viewer' as 'admin' | 'viewer',
})

async function handleSave() {
  // TODO: GraphQL mutation で更新処理を実装
  console.log('save:', id, form)
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

  &:hover {
    background-color: rgba($primary, 0.65);
  }
}
</style>
