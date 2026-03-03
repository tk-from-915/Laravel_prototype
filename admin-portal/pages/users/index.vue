<template>
  <div>
    <div class="list-header">
      <h1 class="page-title">ユーザー一覧</h1>
      <div v-if="isAdmin" class="list-header__actions">
        <NuxtLink to="/users/create" class="btn btn-primary">＋ new</NuxtLink>
        <button
          type="button"
          class="btn btn-danger btn-sm"
          :disabled="checkedIds.length === 0"
          @click="bulkDelete"
        >
          🗑 削除
        </button>
      </div>
    </div>

    <!-- TODO: GraphQL からユーザー一覧を取得して表示する -->
    <div class="content-card" style="padding: 0; overflow: hidden;">
      <table class="admin-table">
        <thead>
          <tr>
            <th v-if="isAdmin" class="col-check">
              <input type="checkbox" :checked="allChecked" @change="toggleAll" />
            </th>
            <th class="col-name">ユーザ名</th>
            <th class="col-email">メールアドレス</th>
            <th class="col-role">権限</th>
            <th class="col-date">作成日時</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="user in users"
            :key="user.id"
            class="list-row"
            :class="{ 'list-row--checked': checkedIds.includes(user.id) }"
          >
            <td v-if="isAdmin" class="col-check">
              <input v-model="checkedIds" type="checkbox" :value="user.id" />
            </td>
            <td class="col-name">
              <NuxtLink :to="`/users/${user.id}`" class="list-row__name-link">
                {{ user.name }}
              </NuxtLink>
            </td>
            <td class="col-email">{{ user.email }}</td>
            <td class="col-role">
              <span class="badge" :class="user.role === 'admin' ? 'badge-admin' : 'badge-viewer'">
                {{ user.role === 'admin' ? '管理者' : '閲覧者' }}
              </span>
            </td>
            <td class="col-date">{{ user.createdAt }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup lang="ts">
const { isAdmin } = useAuth()

// TODO: GraphQL から取得したデータに差し替える
const users = ref([
  { id: 1, name: 'toki',   email: 'aaa@email.com',   role: 'admin',  createdAt: '2020/09/15' },
  { id: 2, name: 'sato_f', email: 'sato@email.com',  role: 'viewer', createdAt: '2020/09/14' },
  { id: 3, name: 'tanaka', email: 'tanaka@email.com', role: 'viewer', createdAt: '2020/12/15' },
])

const checkedIds = ref<number[]>([])
const allChecked = computed(() => checkedIds.value.length === users.value.length)

function toggleAll(e: Event) {
  checkedIds.value = (e.target as HTMLInputElement).checked
    ? users.value.map((u) => u.id)
    : []
}

function bulkDelete() {
  // TODO: GraphQL mutation で一括削除を実装
  if (!confirm(`${checkedIds.value.length}件削除しますか？`)) return
  users.value = users.value.filter((u) => !checkedIds.value.includes(u.id))
  checkedIds.value = []
}
</script>

<style lang="scss" scoped>
.list-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;

  &__actions {
    display: flex;
    gap: 8px;
    align-items: center;
  }
}

.col-check { width: 44px; text-align: center; }
.col-name  { width: 180px; }
.col-email { min-width: 240px; }
.col-role  { width: 120px; text-align: center; }
.col-date  { width: 140px; }

.list-row {
  &:nth-child(even) td { background-color: #f0f0f0; }

  &--checked td { background-color: rgba($primary, 0.06) !important; }

  &__name-link {
    color: $text;
    font-size: 16px;

    &:hover {
      color: $primary;
      text-decoration: underline;
    }
  }
}

.badge-admin  { background-color: $primary; color: #fff; }
.badge-viewer { background-color: $text-muted; color: #fff; }
</style>
