<template>
  <div>
    <div class="list-header">
      <h1 class="page-title">商品 一覧</h1>
      <div class="list-header__actions">
        <NuxtLink to="/products/create" class="btn btn-primary">＋ new</NuxtLink>
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

    <div v-if="loading" class="page-loading">読み込み中...</div>
    <div v-else class="content-card" style="padding: 0; overflow: hidden;">
      <table class="admin-table">
        <thead>
          <tr>
            <th class="col-check">
              <input type="checkbox" :checked="allChecked" @change="toggleAll" />
            </th>
            <th class="col-title">商品名</th>
            <th class="col-category">カテゴリ</th>
            <th class="col-price">価格</th>
            <th class="col-date">登録日時</th>
            <th class="col-action"></th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in productList"
            :key="item.id"
            class="list-row"
            :class="{ 'list-row--checked': checkedIds.includes(item.id) }"
          >
            <td class="col-check">
              <input v-model="checkedIds" type="checkbox" :value="item.id" />
            </td>
            <td class="col-title">
              <NuxtLink :to="`/products/${item.id}`" class="list-row__title-link">
                {{ item.name }}
              </NuxtLink>
              <span class="badge" :class="item.status === 'active' ? 'badge-published' : 'badge-draft'">
                {{ item.status === 'active' ? '公開' : '下書き' }}
              </span>
            </td>
            <td class="col-category">
              <span
                v-for="cat in item.categories"
                :key="cat.id"
                class="category-badge"
              >{{ cat.name }}</span>
            </td>
            <td class="col-price">{{ item.price != null ? `¥${item.price.toLocaleString()}` : '—' }}</td>
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

const LIST_PRODUCTS = gql`
  query ListProducts {
    products(page: 1, perPage: 100) {
      data { id name price status categories { id name } created_at }
    }
  }
`

const DELETE_PRODUCT = gql`
  mutation DeleteProduct($id: ID!) {
    deleteProduct(id: $id)
  }
`

const { result, loading, refetch } = useQuery(LIST_PRODUCTS, null, { fetchPolicy: 'network-only' })
const productList = computed(() => result.value?.products.data ?? [])

const checkedIds = ref<string[]>([])
const allChecked = computed(
  () => productList.value.length > 0 && checkedIds.value.length === productList.value.length,
)

const { mutate: deleteProduct } = useMutation(DELETE_PRODUCT)

function toggleAll(e: Event) {
  checkedIds.value = (e.target as HTMLInputElement).checked
    ? productList.value.map((item: any) => item.id)
    : []
}

function formatDate(dt: string) {
  return new Date(dt).toLocaleDateString('ja-JP')
}

async function deleteItem(id: string) {
  if (!confirm('削除しますか？')) return
  await deleteProduct({ id })
  checkedIds.value = checkedIds.value.filter((cid) => cid !== id)
  await refetch()
}

async function bulkDelete() {
  if (!confirm(`${checkedIds.value.length}件削除しますか？`)) return
  await Promise.all(checkedIds.value.map((id) => deleteProduct({ id })))
  checkedIds.value = []
  await refetch()
}
</script>

<style lang="scss" scoped>
.page-loading {
  padding: 40px;
  text-align: center;
  color: $text-muted;
}

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

.col-check    { width: 44px; text-align: center; }
.col-title    { min-width: 200px; }
.col-category { min-width: 160px; }
.col-price    { width: 100px; text-align: right; }
.col-date     { width: 120px; }
.col-action   { width: 80px; text-align: center; }

.list-row {
  &:nth-child(even) td { background-color: #f0f0f0; }
  &--checked td        { background-color: rgba($primary, 0.06) !important; }

  &__title-link {
    color: $text;
    font-size: 18px;
    margin-right: 8px;
    &:hover { color: $primary; text-decoration: underline; }
  }
}

.category-badge {
  display: inline-block;
  padding: 2px 8px;
  margin: 2px 2px 2px 0;
  background: $primary-light;
  color: $primary-dark;
  border-radius: 20px;
  font-size: 11px;
  white-space: nowrap;
}
</style>
