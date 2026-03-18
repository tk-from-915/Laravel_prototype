<template>
  <div>
    <div class="list-header">
      <h1 class="page-title">お問い合わせ 一覧</h1>
      <div class="list-header__actions">
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
            <th class="col-check">
              <input type="checkbox" :checked="allChecked" @change="toggleAll" />
            </th>
            <th class="col-name">お名前</th>
            <th class="col-tel">TEL</th>
            <th class="col-email">メールアドレス</th>
            <th class="col-type">種別</th>
            <th class="col-status">ステータス</th>
            <th class="col-date">受信日時</th>
            <th class="col-action"></th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in contacts"
            :key="item.id"
            class="list-row"
            :class="{ 'list-row--checked': checkedIds.includes(item.id) }"
          >
            <td class="col-check">
              <input v-model="checkedIds" type="checkbox" :value="item.id" />
            </td>
            <td class="col-name">
              <NuxtLink :to="`/contacts/${item.id}`" class="list-row__name-link">
                {{ item.name }}
              </NuxtLink>
            </td>
            <td class="col-tel">{{ item.tel || '—' }}</td>
            <td class="col-email">{{ item.email }}</td>
            <td class="col-type">{{ item.type }}</td>
            <td class="col-status">
              <span class="badge" :class="statusBadgeClass(item.status)">
                {{ statusLabel(item.status) }}
              </span>
            </td>
            <td class="col-date">{{ formatDate(item.created_at) }}</td>
            <td class="col-action">
              <button type="button" class="btn btn-danger btn-sm" @click="deleteItem(item.id)">削除</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useQuery, useMutation } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const LIST_CONTACTS = gql`
  query ListContacts {
    contacts(page: 1, perPage: 100) {
      data { id name tel email type status created_at }
    }
  }
`

const DELETE_CONTACT = gql`
  mutation DeleteContact($id: ID!) { deleteContact(id: $id) }
`

const { result, loading, refetch } = useQuery(LIST_CONTACTS, null, { fetchPolicy: 'network-only' })
const contacts = computed(() => result.value?.contacts.data ?? [])

const checkedIds = ref<string[]>([])
const allChecked = computed(
  () => contacts.value.length > 0 && checkedIds.value.length === contacts.value.length,
)

const { mutate: deleteContact } = useMutation(DELETE_CONTACT)

function statusLabel(status: string) {
  if (status === 'unread') return '未読'
  if (status === 'read') return '既読'
  return '返信済み'
}

function statusBadgeClass(status: string) {
  return {
    'badge-unread':  status === 'unread',
    'badge-read':    status === 'read',
    'badge-replied': status === 'replied',
  }
}

function formatDate(dt: string) {
  return new Date(dt).toLocaleString('ja-JP')
}

function toggleAll(e: Event) {
  checkedIds.value = (e.target as HTMLInputElement).checked
    ? contacts.value.map((item: any) => item.id)
    : []
}

async function deleteItem(id: string) {
  if (!confirm('削除しますか？')) return
  await deleteContact({ id })
  checkedIds.value = checkedIds.value.filter((cid) => cid !== id)
  await refetch()
}

async function bulkDelete() {
  if (!confirm(`${checkedIds.value.length}件削除しますか？`)) return
  await Promise.all(checkedIds.value.map((id) => deleteContact({ id })))
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

.col-check  { width: 44px; text-align: center; }
.col-name   { width: 140px; }
.col-tel    { width: 140px; }
.col-email  { min-width: 200px; }
.col-type   { min-width: 180px; }
.col-status { width: 100px; text-align: center; }
.col-date   { width: 150px; }
.col-action { width: 80px; text-align: center; }

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

.badge-unread  { background-color: #e05252; color: #fff; }
.badge-read    { background-color: $text-muted; color: #fff; }
.badge-replied { background-color: $primary; color: #fff; }
</style>
