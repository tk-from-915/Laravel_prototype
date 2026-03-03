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

    <!-- TODO: GraphQL から商品一覧を取得して表示する -->
    <div class="content-card" style="padding: 0; overflow: hidden;">
      <table class="admin-table">
        <thead>
          <tr>
            <th class="col-check">
              <input type="checkbox" :checked="allChecked" @change="toggleAll" />
            </th>
            <th class="col-title">商品名</th>
            <th class="col-category">カテゴリ</th>
            <th class="col-price">価格</th>
            <th class="col-author">作成者</th>
            <th class="col-date">投稿日時</th>
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
                {{ item.title }}
              </NuxtLink>
              <span class="badge" :class="item.status === 'published' ? 'badge-published' : 'badge-draft'">
                {{ item.status === 'published' ? '公開' : '下書き' }}
              </span>
            </td>
            <td class="col-category">
              <span
                v-for="cat in item.categories"
                :key="cat"
                class="category-badge"
              >{{ cat }}</span>
            </td>
            <td class="col-price">{{ item.price != null ? `¥${item.price.toLocaleString()}` : '—' }}</td>
            <td class="col-author">{{ item.author }}</td>
            <td class="col-date">{{ item.createdAt }}</td>
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
// TODO: GraphQL から取得したデータに差し替える
const productList = ref([
  { id: 1, title: 'モンステラ',       categories: ['観葉植物'],                  price: 3800,  author: 'toki', createdAt: '2024/01/15', status: 'published' },
  { id: 2, title: 'カジュマル',       categories: ['観葉植物'],                  price: 2500,  author: 'toki', createdAt: '2024/01/20', status: 'published' },
  { id: 3, title: 'エケベリア',       categories: ['多肉植物'],                  price: 1200,  author: 'toki', createdAt: '2024/02/01', status: 'published' },
  { id: 4, title: 'ハオルチア',       categories: ['多肉植物'],                  price: 980,   author: 'toki', createdAt: '2024/02/10', status: 'draft'     },
  { id: 5, title: 'テラリウムセット', categories: ['テラリウム・パルダリウム'],  price: 6800,  author: 'toki', createdAt: '2024/03/05', status: 'published' },
  { id: 6, title: 'コウモリラン',     categories: ['観葉植物', '着生植物'],      price: 4200,  author: 'toki', createdAt: '2024/03/12', status: 'published' },
])

const checkedIds = ref<number[]>([])
const allChecked = computed(() => checkedIds.value.length === productList.value.length)

function toggleAll(e: Event) {
  checkedIds.value = (e.target as HTMLInputElement).checked
    ? productList.value.map((item) => item.id)
    : []
}

function deleteItem(id: number) {
  // TODO: GraphQL mutation で削除処理を実装
  if (!confirm('削除しますか？')) return
  productList.value = productList.value.filter((item) => item.id !== id)
  checkedIds.value = checkedIds.value.filter((cid) => cid !== id)
}

function bulkDelete() {
  // TODO: GraphQL mutation で一括削除を実装
  if (!confirm(`${checkedIds.value.length}件削除しますか？`)) return
  productList.value = productList.value.filter((item) => !checkedIds.value.includes(item.id))
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

.col-check    { width: 44px; text-align: center; }
.col-title    { min-width: 200px; }
.col-category { min-width: 160px; }
.col-price    { width: 100px; text-align: right; }
.col-author   { width: 100px; }
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
