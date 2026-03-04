<template>
  <CommonPageLayout :title="page?.title ?? slug">
    <div v-if="loading" class="loading-text">読み込み中...</div>
    <div v-else-if="page" v-html="page.body"></div>
    <p v-else class="loading-text">ページが見つかりません。</p>
  </CommonPageLayout>
</template>

<script setup lang="ts">
import { useQuery } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const { slug } = useRoute().params as { slug: string }

const GET_PAGE = gql`
  query GetPage($slug: String) {
    page(slug: $slug) { id title body }
  }
`

const { result, loading } = useQuery(GET_PAGE, { slug })
const page = computed(() => result.value?.page ?? null)
</script>

<style scoped>
.loading-text {
  text-align: center;
  padding: 40px;
  color: #a8a8a8;
}
</style>
