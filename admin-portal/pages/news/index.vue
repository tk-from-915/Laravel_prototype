<template>
  <div>
    <div class="list-header">
      <h1 class="page-title">News 一覧</h1>
      <div class="list-header__actions">
        <NuxtLink to="/news/create" class="btn btn-primary">＋ new</NuxtLink>
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
            <th class="col-title">タイトル</th>
            <th class="col-author">作成者ID</th>
            <th class="col-date">投稿日時</th>
            <th class="col-action"></th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in newsList"
            :key="item.id"
            class="list-row"
            :class="{ 'list-row--checked': checkedIds.includes(item.id) }"
          >
            <td class="col-check">
              <input v-model="checkedIds" type="checkbox" :value="item.id" />
            </td>
            <td class="col-title">
              <NuxtLink :to="`/news/${item.id}`" class="list-row__title-link">
                {{ item.title }}
              </NuxtLink>
              <span class="badge" :class="item.status === 'published' ? 'badge-published' : 'badge-draft'">
                {{ item.status === 'published' ? '公開' : '下書き' }}
              </span>
            </td>
            <td class="col-author">{{ item.author_id }}</td>
            <td class="col-date">{{ formatDate(item.published_at ?? item.created_at) }}</td>
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

const LIST_NEWS = gql`
  query ListNews($page: Int, $perPage: Int) {
    posts(type: "news", page: $page, perPage: $perPage) {
      data { id title status author_id published_at created_at }
      total
    }
  }
`

const DELETE_POST = gql`
  mutation DeletePost($id: ID!) { deletePost(id: $id) }
`

const { result, loading, refetch } = useQuery(LIST_NEWS, { page: 1, perPage: 100 })
const newsList = computed(() => result.value?.posts.data ?? [])

const checkedIds = ref<number[]>([])
const allChecked = computed(() =>
  newsList.value.length > 0 && checkedIds.value.length === newsList.value.length,
)

function toggleAll(e: Event) {
  checkedIds.value = (e.target as HTMLInputElement).checked
    ? newsList.value.map((item: any) => Number(item.id))
    : []
}

function formatDate(dt: string | null): string {
  if (!dt) return '—'
  return new Date(dt).toLocaleDateString('ja-JP')
}

const { mutate: deletePost } = useMutation(DELETE_POST)

async function deleteItem(id: number) {
  if (!confirm('削除しますか？')) return
  await deletePost({ id: String(id) })
  checkedIds.value = checkedIds.value.filter((cid) => cid !== id)
  refetch()
}

async function bulkDelete() {
  if (!confirm(`${checkedIds.value.length}件削除しますか？`)) return
  for (const id of checkedIds.value) {
    await deletePost({ id: String(id) })
  }
  checkedIds.value = []
  refetch()
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
.col-title  { min-width: 320px; }
.col-author { width: 120px; }
.col-date   { width: 140px; }
.col-action { width: 80px; text-align: center; }

.list-row {
  &:nth-child(even) td { background-color: #f0f0f0; }

  &--checked td { background-color: rgba($primary, 0.06) !important; }

  &__title-link {
    color: $text;
    font-size: 18px;
    margin-right: 8px;

    &:hover {
      color: $primary;
      text-decoration: underline;
    }
  }
}
</style>
