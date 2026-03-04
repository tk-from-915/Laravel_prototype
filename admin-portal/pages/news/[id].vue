<template>
  <FormPostForm
    title="News 編集"
    :initial-data="initialData"
    @submit="onSubmit"
    @cancel="navigateTo('/news')"
  />
</template>

<script setup lang="ts">
const { id } = useRoute().params as { id: string }

// TODO: GraphQL から id に対応するデータを取得する
const initialData = {
  title: 'クリスマスリース販売中です。',
  content: '<p>ここに本文が入ります。</p>',
  thumbnail: null,
  status: 'published' as const,
}

async function onSubmit(data: { title: string; content: string; thumbnail: string | null; status: string }) {
  // TODO: GraphQL mutation で更新処理を実装
  console.log('update:', id, data)
  await navigateTo('/news')
}
</script>
