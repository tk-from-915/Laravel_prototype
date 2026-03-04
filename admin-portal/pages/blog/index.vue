<template>
  <div>
    <div class="list-header">
      <h1 class="page-title">ブログ 一覧</h1>
      <div class="list-header__actions">
        <NuxtLink to="/blog/create" class="btn btn-primary">＋ new</NuxtLink>
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

    <!-- TODO: GraphQL からブログ一覧を取得して表示する -->
    <div class="content-card" style="padding: 0; overflow: hidden;">
      <table class="admin-table">
        <thead>
          <tr>
            <th class="col-check">
              <input type="checkbox" :checked="allChecked" @change="toggleAll" />
            </th>
            <th class="col-title">タイトル</th>
            <th class="col-author">作成者</th>
            <th class="col-date">投稿日時</th>
            <th class="col-action"></th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in blogList"
            :key="item.id"
            class="list-row"
            :class="{ 'list-row--checked': checkedIds.includes(item.id) }"
          >
            <td class="col-check">
              <input v-model="checkedIds" type="checkbox" :value="item.id" />
            </td>
            <td class="col-title">
              <NuxtLink :to="`/blog/${item.id}`" class="list-row__title-link">
                {{ item.title }}
              </NuxtLink>
              <span class="badge" :class="item.status === 'published' ? 'badge-published' : 'badge-draft'">
                {{ item.status === 'published' ? '公開' : '下書き' }}
              </span>
            </td>
            <td class="col-author">{{ item.author }}</td>
            <td class="col-date">{{ item.publishedAt }}</td>
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
const blogList = ref([
  { id: 1, title: 'ハロウィンに使われる植物とは？',     author: 'toki', publishedAt: '2020/10/31', status: 'published' },
  { id: 2, title: '真夏でも葉焼けしない方法',          author: 'toki', publishedAt: '2020/08/12', status: 'published' },
  { id: 3, title: '梅雨の時期にぴったりの植物はコレ！', author: 'toki', publishedAt: '2020/06/06', status: 'draft'     },
  { id: 4, title: '卒業式＆入学式にはこの花を',        author: 'toki', publishedAt: '2020/04/01', status: 'published' },
  { id: 5, title: '桃の花の時期になりました。',         author: 'toki', publishedAt: '2020/03/03', status: 'published' },
  { id: 6, title: '今年のバレンタインには♡',           author: 'toki', publishedAt: '2020/02/01', status: 'draft'     },
])

const checkedIds = ref<number[]>([])
const allChecked = computed(() => checkedIds.value.length === blogList.value.length)

function toggleAll(e: Event) {
  checkedIds.value = (e.target as HTMLInputElement).checked
    ? blogList.value.map((item) => item.id)
    : []
}

function deleteItem(id: number) {
  // TODO: GraphQL mutation で削除処理を実装
  if (!confirm('削除しますか？')) return
  blogList.value = blogList.value.filter((item) => item.id !== id)
  checkedIds.value = checkedIds.value.filter((cid) => cid !== id)
}

function bulkDelete() {
  // TODO: GraphQL mutation で一括削除を実装
  if (!confirm(`${checkedIds.value.length}件削除しますか？`)) return
  blogList.value = blogList.value.filter((item) => !checkedIds.value.includes(item.id))
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
