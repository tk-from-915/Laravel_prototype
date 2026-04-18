<template>
  <div>
    <div class="list-header">
      <h1 class="page-title">カテゴリ管理</h1>
      <button type="button" class="btn btn-primary" @click="openCreateRow">
        ＋ new
      </button>
    </div>

    <div v-if="loading" class="page-loading">読み込み中...</div>
    <div v-else class="content-card" style="padding: 0; overflow: hidden;">
      <table class="admin-table">
        <thead>
          <tr>
            <th class="col-id">ID</th>
            <th class="col-slug">Slug</th>
            <th class="col-name">Name</th>
            <th class="col-date">登録日時</th>
            <th class="col-action"></th>
          </tr>
        </thead>
        <tbody>
          <!-- 新規作成行 -->
          <tr v-if="isCreating" class="list-row list-row--editing">
            <td class="col-id">—</td>
            <td class="col-slug">
              <input
                v-model="createForm.slug"
                class="inline-input"
                placeholder="例: foliage"
                @keyup.enter="submitCreate"
                @keyup.esc="cancelCreate"
              />
            </td>
            <td class="col-name">
              <input
                v-model="createForm.name"
                class="inline-input"
                placeholder="例: 観葉植物"
                @keyup.enter="submitCreate"
                @keyup.esc="cancelCreate"
              />
            </td>
            <td class="col-date">—</td>
            <td class="col-action">
              <div class="action-buttons">
                <button type="button" class="btn btn-primary btn-sm" :disabled="isSaving" @click="submitCreate">
                  Save
                </button>
                <button type="button" class="btn btn-secondary btn-sm" @click="cancelCreate">
                  Delete
                </button>
              </div>
            </td>
          </tr>

          <!-- 既存カテゴリ行 -->
          <tr
            v-for="item in categories"
            :key="item.id"
            class="list-row"
            :class="{ 'list-row--editing': editingId === item.id }"
          >
            <td class="col-id">{{ item.id }}</td>

            <!-- 編集モード -->
            <template v-if="editingId === item.id">
              <td class="col-slug">
                <input
                  v-model="editForm.slug"
                  class="inline-input"
                  @keyup.enter="submitEdit(item.id)"
                  @keyup.esc="cancelEdit"
                />
              </td>
              <td class="col-name">
                <input
                  v-model="editForm.name"
                  class="inline-input"
                  @keyup.enter="submitEdit(item.id)"
                  @keyup.esc="cancelEdit"
                />
              </td>
            </template>

            <!-- 表示モード -->
            <template v-else>
              <td class="col-slug">{{ item.slug }}</td>
              <td class="col-name">{{ item.name }}</td>
            </template>

            <td class="col-date">{{ formatDate(item.created_at) }}</td>
            <td class="col-action">
              <div class="action-buttons">
                <template v-if="editingId === item.id">
                  <button type="button" class="btn btn-primary btn-sm" :disabled="isSaving" @click="submitEdit(item.id)">
                    Save
                  </button>
                  <button type="button" class="btn btn-secondary btn-sm" @click="cancelEdit">
                    Cancel
                  </button>
                </template>
                <template v-else>
                  <button type="button" class="btn btn-secondary btn-sm" @click="startEdit(item)">
                    Edit
                  </button>
                  <button type="button" class="btn btn-danger btn-sm" @click="deleteItem(item.id)">
                    Delete
                  </button>
                </template>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- エラートースト -->
    <div v-if="errorMessage" class="error-toast">
      {{ errorMessage }}
    </div>
  </div>
</template>

<script setup lang="ts">
import { useQuery, useMutation } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const LIST_CATEGORIES = gql`
  query ListCategories {
    categories { id slug name created_at }
  }
`

const CREATE_CATEGORY = gql`
  mutation CreateCategory($slug: String!, $name: String!) {
    createCategory(slug: $slug, name: $name) { id slug name created_at }
  }
`

const UPDATE_CATEGORY = gql`
  mutation UpdateCategory($id: ID!, $slug: String!, $name: String!) {
    updateCategory(id: $id, slug: $slug, name: $name) { id slug name created_at }
  }
`

const DELETE_CATEGORY = gql`
  mutation DeleteCategory($id: ID!) {
    deleteCategory(id: $id)
  }
`

const { result, loading, refetch } = useQuery(LIST_CATEGORIES, null, { fetchPolicy: 'network-only' })
const categories = computed(() => result.value?.categories ?? [])

const { mutate: createCategory } = useMutation(CREATE_CATEGORY)
const { mutate: updateCategory } = useMutation(UPDATE_CATEGORY)
const { mutate: deleteCategory } = useMutation(DELETE_CATEGORY)

// 新規作成
const isCreating = ref(false)
const createForm = ref({ slug: '', name: '' })

function openCreateRow() {
  cancelEdit()
  isCreating.value = true
  createForm.value = { slug: '', name: '' }
}

function cancelCreate() {
  isCreating.value = false
  createForm.value = { slug: '', name: '' }
}

// 編集
const editingId = ref<string | null>(null)
const editForm = ref({ slug: '', name: '' })

function startEdit(item: any) {
  cancelCreate()
  editingId.value = item.id
  editForm.value = { slug: item.slug, name: item.name }
}

function cancelEdit() {
  editingId.value = null
  editForm.value = { slug: '', name: '' }
}

// 保存・削除
const isSaving = ref(false)
const errorMessage = ref<string | null>(null)

function showError(msg: string) {
  errorMessage.value = msg
  setTimeout(() => { errorMessage.value = null }, 4000)
}

async function submitCreate() {
  if (!createForm.value.slug.trim() || !createForm.value.name.trim()) {
    showError('Slug とnameは必須です')
    return
  }
  isSaving.value = true
  try {
    await createCategory({ slug: createForm.value.slug.trim(), name: createForm.value.name.trim() })
    cancelCreate()
    await refetch()
  } catch (e: any) {
    showError(extractError(e))
  } finally {
    isSaving.value = false
  }
}

async function submitEdit(id: string) {
  if (!editForm.value.slug.trim() || !editForm.value.name.trim()) {
    showError('Slug とnameは必須です')
    return
  }
  isSaving.value = true
  try {
    await updateCategory({ id, slug: editForm.value.slug.trim(), name: editForm.value.name.trim() })
    cancelEdit()
    await refetch()
  } catch (e: any) {
    showError(extractError(e))
  } finally {
    isSaving.value = false
  }
}

async function deleteItem(id: string) {
  if (!confirm('削除しますか？')) return
  try {
    await deleteCategory({ id })
    await refetch()
  } catch (e: any) {
    showError(extractError(e))
  }
}

function extractError(e: any): string {
  const msg: string = e?.graphQLErrors?.[0]?.message ?? e?.message ?? '予期しないエラーが発生しました'
  if (msg.includes('Slug already exists')) return '他のカテゴリのslugと同じものは登録できません'
  if (msg.includes('products are still linked')) return 'このカテゴリには商品が紐づいているため削除できません'
  return msg
}

function formatDate(dt: string) {
  return new Date(dt).toLocaleDateString('ja-JP')
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
}

.col-id     { width: 60px; text-align: center; }
.col-slug   { min-width: 160px; }
.col-name   { min-width: 200px; }
.col-date   { width: 120px; }
.col-action { width: 160px; text-align: center; }

.list-row {
  &:nth-child(even) td { background-color: #f0f0f0; }

  &--editing td {
    background-color: rgba($primary, 0.05) !important;
  }
}

.action-buttons {
  display: flex;
  gap: 4px;
  justify-content: center;
}

.inline-input {
  width: 100%;
  padding: 4px 8px;
  border: 1px solid $primary;
  border-radius: $border-radius;
  font-size: 14px;
  outline: none;

  &:focus {
    box-shadow: 0 0 0 2px rgba($primary, 0.2);
  }
}

.error-toast {
  position: fixed;
  bottom: 24px;
  left: 50%;
  transform: translateX(-50%);
  background: #e53e3e;
  color: #fff;
  padding: 12px 24px;
  border-radius: $border-radius;
  font-size: 14px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
  z-index: 9999;
}
</style>
