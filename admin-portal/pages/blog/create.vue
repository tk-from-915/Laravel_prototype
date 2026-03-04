<template>
  <FormPostForm
    title="ブログ 新規作成"
    @submit="onSubmit"
    @cancel="navigateTo('/blog')"
  />
</template>

<script setup lang="ts">
import { useMutation } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const CREATE_POST = gql`
  mutation CreateBlog($title: String!, $body: String!, $status: String) {
    createPost(type: "blog", title: $title, body: $body, status: $status) { id }
  }
`

const { mutate: createPost } = useMutation(CREATE_POST)

async function onSubmit(data: { title: string; content: string; thumbnail: string | null; status: string }) {
  await createPost({ title: data.title, body: data.content, status: data.status })
  await navigateTo('/blog')
}
</script>
