<template>
  <FormPostForm
    title="ブログ 新規作成"
    @submit="onSubmit"
    @cancel="navigateTo('/blog')"
  />
</template>

<script setup lang="ts">
async function onSubmit(data: { title: string; content: string; thumbnail: string | null; status: string }) {
  // TODO: GraphQL mutation で保存処理を実装
  console.log('submit:', data)
  await navigateTo('/blog')
}
</script>
