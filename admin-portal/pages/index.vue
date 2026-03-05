<template>
  <div class="dashboard">
    <!-- 最新商品情報 -->
    <div class="activity-section">
      <h2 class="activity-section__title">最新商品情報</h2>
      <div class="activity-card">
        <div class="activity-card__inner">
          <p v-if="productsLoading" class="activity-item">読み込み中...</p>
          <p v-else-if="recentProducts.length === 0" class="activity-item activity-item--empty">データがありません</p>
          <p v-for="item in recentProducts" :key="item.id" class="activity-item">
            {{ formatDate(item.created_at) }}&nbsp;&nbsp;「{{ item.name }}」 が追加されました。
          </p>
        </div>
      </div>
    </div>

    <!-- 最新News情報 -->
    <div class="activity-section">
      <h2 class="activity-section__title">最新News情報</h2>
      <div class="activity-card">
        <div class="activity-card__inner">
          <p v-if="newsLoading" class="activity-item">読み込み中...</p>
          <p v-else-if="recentNews.length === 0" class="activity-item activity-item--empty">データがありません</p>
          <p v-for="item in recentNews" :key="item.id" class="activity-item">
            {{ formatDate(item.created_at) }}&nbsp;&nbsp;「{{ item.title }}」 が投稿されました。
          </p>
        </div>
      </div>
    </div>

    <!-- 最新Blog情報 -->
    <div class="activity-section">
      <h2 class="activity-section__title">最新Blog情報</h2>
      <div class="activity-card">
        <div class="activity-card__inner">
          <p v-if="blogLoading" class="activity-item">読み込み中...</p>
          <p v-else-if="recentBlog.length === 0" class="activity-item activity-item--empty">データがありません</p>
          <p v-for="item in recentBlog" :key="item.id" class="activity-item">
            {{ formatDate(item.created_at) }}&nbsp;&nbsp;「{{ item.title }}」 が投稿されました。
          </p>
        </div>
      </div>
    </div>

    <!-- 最新お問い合わせ情報 -->
    <div class="activity-section">
      <h2 class="activity-section__title">最新お問い合わせ情報</h2>
      <div class="activity-card">
        <div class="activity-card__inner">
          <p v-if="contactsLoading" class="activity-item">読み込み中...</p>
          <p v-else-if="recentContacts.length === 0" class="activity-item activity-item--empty">データがありません</p>
          <p v-for="item in recentContacts" :key="item.id" class="activity-item">
            {{ formatDate(item.created_at) }}&nbsp;&nbsp;{{ item.name }} さんから「{{ item.type }}」のお問い合わせを頂きました。
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useQuery } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const RECENT_PRODUCTS = gql`
  query RecentProducts {
    products(page: 1, perPage: 3) {
      data { id name created_at }
    }
  }
`

const RECENT_NEWS = gql`
  query RecentNews {
    posts(type: "news", page: 1, perPage: 3) {
      data { id title created_at }
    }
  }
`

const RECENT_BLOG = gql`
  query RecentBlog {
    posts(type: "blog", page: 1, perPage: 3) {
      data { id title created_at }
    }
  }
`

const RECENT_CONTACTS = gql`
  query RecentContacts {
    contacts(page: 1, perPage: 3) {
      data { id name type created_at }
    }
  }
`

const { result: productsResult, loading: productsLoading } = useQuery(RECENT_PRODUCTS)
const { result: newsResult,     loading: newsLoading }     = useQuery(RECENT_NEWS)
const { result: blogResult,     loading: blogLoading }     = useQuery(RECENT_BLOG)
const { result: contactsResult, loading: contactsLoading } = useQuery(RECENT_CONTACTS)

const recentProducts = computed(() => productsResult.value?.products.data ?? [])
const recentNews     = computed(() => newsResult.value?.posts.data ?? [])
const recentBlog     = computed(() => blogResult.value?.posts.data ?? [])
const recentContacts = computed(() => contactsResult.value?.contacts.data ?? [])

function formatDate(dt: string) {
  return new Date(dt).toLocaleDateString('ja-JP')
}
</script>

<style lang="scss" scoped>
.dashboard {
  display: flex;
  flex-direction: column;
  gap: 40px;
}

.activity-section {
  &__title {
    font-size: 24px;
    color: $primary;
    margin-bottom: 12px;
    font-weight: normal;
  }
}

.activity-card {
  background: rgba($primary, 0.4);
  border: 1px solid #fff;
  padding: 8px;

  &__inner {
    background: #fff;
    border: 1px solid rgba($primary, 0.4);
    padding: 16px 24px;
  }
}

.activity-item {
  color: $text-muted;
  font-size: 18px;
  padding: 10px 0;

  & + & {
    border-top: none;
  }

  &--empty {
    font-size: 15px;
  }
}
</style>
