<template>
  <div id="backgroud">
    <div id="post_archive">
      <h3 id="news_archive_title">News</h3>
      <div v-if="loading" class="loading-text">読み込み中...</div>
      <template v-else>
        <NuxtLink
          v-for="post in posts"
          :key="post.id"
          :to="`/news/${post.id}`"
        >
          <div class="post_block">
            <div class="post_thumnail"></div>
            <div class="post_title">{{ post.title }}</div>
            <div class="post_created_at">{{ formatDate(post.published_at ?? post.created_at) }}</div>
          </div>
        </NuxtLink>
        <p v-if="posts.length === 0" class="loading-text">記事がありません</p>
      </template>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useQuery } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const LIST_NEWS = gql`
  query ListNews {
    posts(type: "news", status: "published", page: 1, perPage: 20) {
      data { id title published_at created_at }
    }
  }
`

const { result, loading } = useQuery(LIST_NEWS, null, { fetchPolicy: 'network-only' })
const posts = computed(() => result.value?.posts.data ?? [])

function formatDate(dt: string | null) {
  if (!dt) return ''
  return new Date(dt).toLocaleDateString('ja-JP')
}
</script>

<style scoped>
.loading-text {
  text-align: center;
  padding: 40px;
  color: #a8a8a8;
}
</style>
