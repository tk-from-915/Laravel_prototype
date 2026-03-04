<template>
  <div id="backgroud">
    <div id="post_archive">
      <div v-if="loading" class="loading-text">読み込み中...</div>
      <template v-else-if="post">
        <h5 id="news_blog_title">{{ post.title }}</h5>
        <div class="post_content" v-html="post.body"></div>
      </template>
      <p v-else class="loading-text">記事が見つかりません。</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useQuery } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const { id } = useRoute().params as { id: string }

const GET_POST = gql`
  query GetPost($id: ID!) {
    post(id: $id) { id title body }
  }
`

const { result, loading } = useQuery(GET_POST, { id })
const post = computed(() => result.value?.post ?? null)
</script>

<style scoped>
.loading-text {
  text-align: center;
  padding: 40px;
  color: #a8a8a8;
}
</style>
