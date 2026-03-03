<template>
  <div class="contact-detail">
    <div class="contact-detail__header">
      <h1 class="page-title">お問い合わせ 詳細</h1>
      <NuxtLink to="/contacts" class="btn btn-secondary btn-sm">← 一覧に戻る</NuxtLink>
    </div>

    <!-- ステータス表示 -->
    <div class="contact-detail__meta">
      <span class="badge" :class="statusBadgeClass(contact.status)">{{ contact.status }}</span>
      <span class="contact-detail__date">受信日時: {{ contact.receivedAt }}</span>
    </div>

    <!-- タブ -->
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

    <!-- タブ: 投稿者からの内容 -->
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

    <!-- タブ: 返信 -->
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
type ContactStatus = '未読' | '既読' | '返信済み'

const { id } = useRoute().params as { id: string }

// TODO: GraphQL から id に対応するデータを取得する
const contact = reactive({
  id: Number(id),
  name:      '山田 太郎',
  tel:       '090-1234-5678',
  email:     'yamada@example.com',
  type:      '商品・店舗に関するお問い合わせ',
  message:   'モンステラの育て方について質問があります。水やりの頻度と日当たりの条件を教えていただけますか？',
  status:    '未読' as ContactStatus,
  receivedAt: '2024/03/01 10:23',
})

// 詳細を開いたら「未読」→「既読」に自動更新
onMounted(() => {
  if (contact.status === '未読') {
    // TODO: GraphQL mutation でステータスを更新する
    contact.status = '既読'
  }
})

const activeTab = ref<'content' | 'reply'>('content')

const replyForm = reactive({
  subject: '',
  body: '',
})

function statusBadgeClass(status: ContactStatus) {
  return {
    'badge-unread':   status === '未読',
    'badge-read':     status === '既読',
    'badge-replied':  status === '返信済み',
  }
}

async function sendReply() {
  // TODO: Laravel Mail でメール送信 + GraphQL mutation でステータスを「返信済み」に更新
  contact.status = '返信済み'
  alert(`${contact.email} に返信を送信しました。`)
  await navigateTo('/contacts')
}
</script>

<style lang="scss" scoped>
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

/* タブ */
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

/* コンテンツカード */
.contact-card {
  background-color: rgba(#CDF4F4, 0.5);
  border-radius: 0 10px 10px 10px;
  padding: 28px 32px;

  &__row {
    display: flex;
    align-items: flex-start;
    padding: 12px 0;
    border-bottom: 1px solid rgba($primary, 0.15);

    &:last-child {
      border-bottom: none;
    }

    &--message {
      align-items: flex-start;
    }
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

/* 返信フォーム */
.reply-form {
  &__group {
    margin-bottom: 20px;
  }

  &__label {
    display: block;
    font-size: 14px;
    color: $text-muted;
    margin-bottom: 6px;
  }

  &__input {
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
    width: 100%;
    padding: 10px 12px;
    border: 1px solid $border;
    border-radius: $border-radius;
    font-size: 15px;
    background: #fff;
    resize: vertical;
    box-sizing: border-box;
    line-height: 1.7;

    &:focus {
      outline: none;
      border-color: $primary;
    }
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
