<template>
  <div>
    <div class="list-header">
      <h1 class="page-title">コメント管理</h1>
      <div class="list-header__actions">
        <select v-model="statusFilter" class="status-filter" @change="refetch()">
          <option value="">すべて</option>
          <option value="pending">未承認</option>
          <option value="approved">承認済み</option>
          <option value="rejected">却下</option>
        </select>
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
            <th class="col-product">商品ID</th>
            <th class="col-name">ハンドルネーム</th>
            <th class="col-body">コメント</th>
            <th class="col-status">ステータス</th>
            <th class="col-date">投稿日時</th>
            <th class="col-action"></th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in comments"
            :key="item.id"
            class="list-row"
            :class="{ 'list-row--checked': checkedIds.includes(item.id) }"
          >
            <td class="col-check">
              <input v-model="checkedIds" type="checkbox" :value="item.id" />
            </td>
            <td class="col-product">
              <NuxtLink :to="`/products/${item.product_id}`" class="list-row__link">
                #{{ item.product_id }}
              </NuxtLink>
            </td>
            <td class="col-name">{{ item.name }}</td>
            <td class="col-body">{{ item.body }}</td>
            <td class="col-status">
              <span class="badge" :class="statusBadgeClass(item.status)">
                {{ statusLabel(item.status) }}
              </span>
            </td>
            <td class="col-date">{{ formatDate(item.created_at) }}</td>
            <td class="col-action">
              <div class="action-buttons">
                <button
                  v-if="item.status !== 'approved'"
                  type="button"
                  class="btn btn-primary btn-sm"
                  @click="updateStatus(item.id, 'approved')"
                >
                  承認
                </button>
                <button
                  v-if="item.status !== 'rejected'"
                  type="button"
                  class="btn btn-secondary btn-sm"
                  @click="updateStatus(item.id, 'rejected')"
                >
                  却下
                </button>
                <button
                  type="button"
                  class="btn btn-danger btn-sm"
                  @click="deleteItem(item.id)"
                >
                  削除
                </button>
              </div>
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

const LIST_ALL_COMMENTS = gql`
  query ListAllComments($status: String) {
    allProductComments(status: $status) {
      id product_id name body status created_at
    }
  }
`

const UPDATE_STATUS = gql`
  mutation UpdateCommentStatus($id: ID!, $status: String!) {
    updateCommentStatus(id: $id, status: $status) { id status }
  }
`

const DELETE_COMMENT = gql`
  mutation DeleteComment($id: ID!) { deleteComment(id: $id) }
`

const statusFilter = ref('')

const { result, loading, refetch } = useQuery(
  LIST_ALL_COMMENTS,
  () => ({ status: statusFilter.value || null }),
  { fetchPolicy: 'network-only' },
)
const comments = computed(() => result.value?.allProductComments ?? [])

const checkedIds = ref<string[]>([])
const allChecked = computed(
  () => comments.value.length > 0 && checkedIds.value.length === comments.value.length,
)

const { mutate: updateCommentStatus } = useMutation(UPDATE_STATUS)
const { mutate: deleteComment } = useMutation(DELETE_COMMENT)

function statusLabel(status: string) {
  if (status === 'pending')  return '未承認'
  if (status === 'approved') return '承認済み'
  return '却下'
}

function statusBadgeClass(status: string) {
  return {
    'badge-pending':  status === 'pending',
    'badge-approved': status === 'approved',
    'badge-rejected': status === 'rejected',
  }
}

function formatDate(dt: string) {
  return new Date(dt).toLocaleString('ja-JP')
}

function toggleAll(e: Event) {
  checkedIds.value = (e.target as HTMLInputElement).checked
    ? comments.value.map((item: any) => item.id)
    : []
}

async function updateStatus(id: string, status: string) {
  await updateCommentStatus({ id, status })
  await refetch()
}

async function deleteItem(id: string) {
  if (!confirm('削除しますか？')) return
  await deleteComment({ id })
  checkedIds.value = checkedIds.value.filter((cid) => cid !== id)
  await refetch()
}

async function bulkDelete() {
  if (!confirm(`${checkedIds.value.length}件削除しますか？`)) return
  await Promise.all(checkedIds.value.map((id) => deleteComment({ id })))
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

.status-filter {
  padding: 6px 10px;
  border: 1px solid $border;
  border-radius: $border-radius;
  font-size: 14px;
  background: #fff;
  cursor: pointer;

  &:focus {
    outline: none;
    border-color: $primary;
  }
}

.list-loading {
  padding: 40px;
  text-align: center;
  color: $text-muted;
}

.col-check   { width: 44px; text-align: center; }
.col-product { width: 80px; text-align: center; }
.col-name    { width: 140px; }
.col-body    { min-width: 200px; }
.col-status  { width: 100px; text-align: center; }
.col-date    { width: 150px; }
.col-action  { width: 180px; text-align: center; }

.list-row {
  &:nth-child(even) td { background-color: #f0f0f0; }
  &--checked td { background-color: rgba($primary, 0.06) !important; }

  &__link {
    color: $primary;
    &:hover { text-decoration: underline; }
  }
}

.action-buttons {
  display: flex;
  gap: 4px;
  justify-content: center;
}

.badge-pending  { background-color: #e09a30; color: #fff; }
.badge-approved { background-color: $primary; color: #fff; }
.badge-rejected { background-color: $text-muted; color: #fff; }
</style>
