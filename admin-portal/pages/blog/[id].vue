<template>
  <div v-if="loading" class="page-loading">読み込み中...</div>
  <FormPostForm
    v-else-if="post"
    title="ブログ 編集"
    :initial-data="initialData"
    @submit="onSubmit"
    @cancel="navigateTo('/blog')"
  />
</template>

<script setup lang="ts">
import { useQuery, useMutation } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const { id } = useRoute().params as { id: string }

const GET_POST = gql`
  query GetPost($id: ID!) {
    post(id: $id) { id title body status }
  }
`

const UPDATE_POST = gql`
  mutation UpdatePost($id: ID!, $title: String, $body: String) {
    updatePost(id: $id, title: $title, body: $body) { id }
  }
`

const PUBLISH_POST = gql`
  mutation PublishPost($id: ID!, $publish: Boolean) {
    publishPost(id: $id, publish: $publish) { id status }
  }
`

const { result, loading } = useQuery(GET_POST, { id })
const post = computed(() => result.value?.post ?? null)

const initialData = computed(() =>
  post.value
    ? { title: post.value.title, content: post.value.body, status: post.value.status, thumbnail: null }
    : undefined,
)

const { mutate: updatePost } = useMutation(UPDATE_POST)
const { mutate: publishPost } = useMutation(PUBLISH_POST)

async function onSubmit(data: { title: string; content: string; thumbnail: string | null; status: string }) {
  await updatePost({ id, title: data.title, body: data.content })
  await publishPost({ id, publish: data.status === 'published' })
  await navigateTo('/blog')
}
</script>

<style lang="scss" scoped>
.page-loading {
  padding: 40px;
  text-align: center;
  color: $text-muted;
}
</style>
