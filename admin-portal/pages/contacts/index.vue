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

    <!-- TODO: GraphQL からお問い合わせ一覧を取得して表示する -->
    <div class="content-card" style="padding: 0; overflow: hidden;">
      <table class="admin-table">
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
                {{ item.status }}
              </span>
            </td>
            <td class="col-date">{{ item.receivedAt }}</td>
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
type ContactStatus = '未読' | '既読' | '返信済み'

// TODO: GraphQL から取得したデータに差し替える
const contacts = ref([
  { id: 1, name: '山田 太郎',   tel: '090-1234-5678', email: 'yamada@example.com', type: '商品・店舗に関するお問い合わせ', status: '未読'    as ContactStatus, receivedAt: '2024/03/01 10:23' },
  { id: 2, name: '鈴木 花子',   tel: '',              email: 'suzuki@example.com', type: '採用情報に関するお問い合わせ',   status: '既読'    as ContactStatus, receivedAt: '2024/02/28 14:05' },
  { id: 3, name: '佐藤 一郎',   tel: '080-9876-5432', email: 'sato@example.com',   type: 'その他',                       status: '返信済み' as ContactStatus, receivedAt: '2024/02/20 09:12' },
  { id: 4, name: '田中 美咲',   tel: '070-1111-2222', email: 'tanaka@example.com', type: '商品・店舗に関するお問い合わせ', status: '未読'    as ContactStatus, receivedAt: '2024/02/15 16:44' },
  { id: 5, name: '伊藤 健',     tel: '',              email: 'ito@example.com',    type: 'その他',                       status: '返信済み' as ContactStatus, receivedAt: '2024/02/10 11:30' },
])

const checkedIds = ref<number[]>([])
const allChecked = computed(() => checkedIds.value.length === contacts.value.length)

function statusBadgeClass(status: ContactStatus) {
  return {
    'badge-unread':   status === '未読',
    'badge-read':     status === '既読',
    'badge-replied':  status === '返信済み',
  }
}

function toggleAll(e: Event) {
  checkedIds.value = (e.target as HTMLInputElement).checked
    ? contacts.value.map((item) => item.id)
    : []
}

function deleteItem(id: number) {
  // TODO: GraphQL mutation で削除処理を実装
  if (!confirm('削除しますか？')) return
  contacts.value = contacts.value.filter((item) => item.id !== id)
  checkedIds.value = checkedIds.value.filter((cid) => cid !== id)
}

function bulkDelete() {
  // TODO: GraphQL mutation で一括削除を実装
  if (!confirm(`${checkedIds.value.length}件削除しますか？`)) return
  contacts.value = contacts.value.filter((item) => !checkedIds.value.includes(item.id))
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
