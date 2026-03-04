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

    <div class="content-card" style="padding: 0; overflow: hidden;">
      <div v-if="loading" class="list-loading">読み込み中...</div>
      <table v-else class="admin-table">
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
            <td class="col-date">{{ formatDate(user.created_at) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useQuery, useMutation } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const LIST_USERS = gql`
  query ListUsers {
    users(page: 1, perPage: 100) {
      data { id name email role created_at }
    }
  }
`

const DELETE_USER = gql`
  mutation DeleteUser($id: ID!) { deleteUser(id: $id) }
`

const { isAdmin } = useAuth()
const { result, loading, refetch } = useQuery(LIST_USERS, null, { fetchPolicy: 'network-only' })
const users = computed(() => result.value?.users.data ?? [])

const checkedIds = ref<string[]>([])
const allChecked = computed(
  () => users.value.length > 0 && checkedIds.value.length === users.value.length,
)

const { mutate: deleteUser } = useMutation(DELETE_USER)

function formatDate(dt: string) {
  return new Date(dt).toLocaleDateString('ja-JP')
}

function toggleAll(e: Event) {
  checkedIds.value = (e.target as HTMLInputElement).checked
    ? users.value.map((u: any) => u.id)
    : []
}

async function bulkDelete() {
  if (!confirm(`${checkedIds.value.length}件削除しますか？`)) return
  await Promise.all(checkedIds.value.map((id) => deleteUser({ id })))
  checkedIds.value = []
  await refetch()
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

.list-loading {
  padding: 40px;
  text-align: center;
  color: $text-muted;
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
