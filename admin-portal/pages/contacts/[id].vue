<template>
  <div v-if="loading" class="page-loading">読み込み中...</div>
  <div v-else-if="contact" class="contact-detail">
    <div class="contact-detail__header">
      <h1 class="page-title">お問い合わせ 詳細</h1>
      <NuxtLink to="/contacts" class="btn btn-secondary btn-sm">← 一覧に戻る</NuxtLink>
    </div>

    <div class="contact-detail__meta">
      <span class="badge" :class="statusBadgeClass(displayStatus)">{{ statusLabel(displayStatus) }}</span>
      <span class="contact-detail__date">受信日時: {{ formatDate(contact.created_at) }}</span>
    </div>

    <div class="contact-tabs">
      <button
        class="contact-tabs__tab"
        :class="{ 'contact-tabs__tab--active': activeTab === 'content' }"
        @click="activeTab = 'content'"
      >
        投稿者からの内容
      </button>
      <button
        class="contact-tabs__tab"
        :class="{ 'contact-tabs__tab--active': activeTab === 'reply' }"
        @click="activeTab = 'reply'"
      >
        返信
      </button>
    </div>

    <div v-if="activeTab === 'content'" class="contact-card">
      <div class="contact-card__row">
        <span class="contact-card__label">お名前</span>
        <span class="contact-card__value">{{ contact.name }}</span>
      </div>
      <div class="contact-card__row">
        <span class="contact-card__label">電話番号</span>
        <span class="contact-card__value">{{ contact.tel || '—' }}</span>
      </div>
      <div class="contact-card__row">
        <span class="contact-card__label">メールアドレス</span>
        <a :href="`mailto:${contact.email}`" class="contact-card__email">{{ contact.email }}</a>
      </div>
      <div class="contact-card__row">
        <span class="contact-card__label">種別</span>
        <span class="contact-card__value">{{ contact.type }}</span>
      </div>
      <div class="contact-card__row contact-card__row--message">
        <span class="contact-card__label">お問い合わせ内容</span>
        <p class="contact-card__message">{{ contact.message }}</p>
      </div>
    </div>

    <div v-if="activeTab === 'reply'" class="contact-card">
      <form @submit.prevent="sendReply">
        <div class="reply-form__group">
          <label class="reply-form__label">件名</label>
          <input
            v-model="replyForm.subject"
            type="text"
            class="reply-form__input"
            placeholder="Re: お問い合わせありがとうございます"
            required
          />
        </div>
        <div class="reply-form__group">
          <label class="reply-form__label">本文</label>
          <textarea
            v-model="replyForm.body"
            class="reply-form__textarea"
            rows="12"
            placeholder="返信内容を入力してください"
            required
          ></textarea>
        </div>
        <div class="reply-form__actions">
          <button type="submit" class="btn btn-primary">送信する</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useQuery, useMutation } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const { id } = useRoute().params as { id: string }

const GET_CONTACT = gql`
  query GetContact($id: ID!) {
    contact(id: $id) { id name tel email type message status created_at }
  }
`

const UPDATE_STATUS = gql`
  mutation UpdateContactStatus($id: ID!, $status: String!) {
    updateContactStatus(id: $id, status: $status) { id status }
  }
`

const { result, loading } = useQuery(GET_CONTACT, { id }, { fetchPolicy: 'network-only' })
const contact = computed(() => result.value?.contact ?? null)

// ローカルステータス（mutation後の即時反映用）
const displayStatus = ref('')

const { mutate: updateStatus } = useMutation(UPDATE_STATUS)

// データロード完了時: unread なら read に更新
watch(contact, (val) => {
  if (!val) return
  if (val.status === 'unread') {
    updateStatus({ id, status: 'read' })
    displayStatus.value = 'read'
  } else {
    displayStatus.value = val.status
  }
}, { immediate: true })

const activeTab = ref<'content' | 'reply'>('content')
const replyForm = reactive({ subject: '', body: '' })

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

async function sendReply() {
  await updateStatus({ id, status: 'replied' })
  displayStatus.value = 'replied'
  alert(`${contact.value?.email} に返信を送信しました。`)
  await navigateTo('/contacts')
}
</script>

<style lang="scss" scoped>
.page-loading {
  padding: 40px;
  text-align: center;
  color: $text-muted;
}

.contact-detail {
  &__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
  }

  &__meta {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
  }

  &__date {
    font-size: 14px;
    color: $text-muted;
  }
}

.contact-tabs {
  display: flex;
  gap: 0;
  margin-bottom: 0;

  &__tab {
    padding: 10px 28px;
    font-size: 15px;
    border: none;
    cursor: pointer;
    border-radius: 8px 8px 0 0;
    background-color: #90c9cc;
    color: #fff;
    transition: background-color 0.15s, color 0.15s;

    &--active {
      background-color: rgba(#CDF4F4, 0.5);
      color: $text;
      font-weight: bold;
    }

    &:hover:not(&--active) {
      background-color: #7ab8bc;
    }
  }
}

.contact-card {
  background-color: rgba(#CDF4F4, 0.5);
  border-radius: 0 10px 10px 10px;
  padding: 28px 32px;

  &__row {
    display: flex;
    align-items: flex-start;
    padding: 12px 0;
    border-bottom: 1px solid rgba($primary, 0.15);

    &:last-child { border-bottom: none; }
    &--message { align-items: flex-start; }
  }

  &__label {
    width: 160px;
    flex-shrink: 0;
    font-size: 14px;
    color: $text-muted;
    padding-top: 2px;
  }

  &__value {
    font-size: 16px;
    color: $text;
  }

  &__email {
    font-size: 16px;
    color: $primary;
    text-decoration: underline;
  }

  &__message {
    font-size: 16px;
    color: $text;
    white-space: pre-wrap;
    margin: 0;
    line-height: 1.7;
  }
}

.reply-form {
  &__group { margin-bottom: 20px; }

  &__label {
    display: block;
    font-size: 14px;
    color: $text-muted;
    margin-bottom: 6px;
  }

  &__input,
  &__textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid $border;
    border-radius: $border-radius;
    font-size: 15px;
    background: #fff;
    box-sizing: border-box;

    &:focus {
      outline: none;
      border-color: $primary;
    }
  }

  &__textarea {
    resize: vertical;
    line-height: 1.7;
  }

  &__actions {
    display: flex;
    justify-content: flex-end;
  }
}

.badge-unread  { background-color: #e05252; color: #fff; }
.badge-read    { background-color: $text-muted; color: #fff; }
.badge-replied { background-color: $primary; color: #fff; }
</style>
