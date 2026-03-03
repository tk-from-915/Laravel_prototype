<template>
  <FormPostForm
    title="ブログ 編集"
    :initial-data="initialData"
    @submit="onSubmit"
    @cancel="navigateTo('/blog')"
  />
</template>

<script setup lang="ts">
const { id } = useRoute().params as { id: string }

// TODO: GraphQL から id に対応するデータを取得する
const initialData = {
  title: 'ハロウィンに使われる植物とは？',
  content: '<p>ここに本文が入ります。</p>',
  thumbnail: null,
  status: 'published' as const,
}

async function onSubmit(data: { title: string; content: string; thumbnail: string | null; status: string }) {
  // TODO: GraphQL mutation で更新処理を実装
  console.log('update:', id, data)
  await navigateTo('/blog')
}
</script>
