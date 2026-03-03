<template>
  <FormProductForm
    title="商品 編集"
    :initial-data="initialData"
    @submit="onSubmit"
    @cancel="navigateTo('/products')"
  />
</template>

<script setup lang="ts">
const { id } = useRoute().params as { id: string }

// TODO: GraphQL から id に対応するデータを取得する
const initialData = {
  title:      'モンステラ',
  price:      3800,
  categories: ['foliage'] as const,
  thumbnail:  null,
  content:    '<p>ここに商品説明が入ります。</p>',
  status:     'published' as const,
}

async function onSubmit(data: object) {
  // TODO: GraphQL mutation で更新処理を実装
  console.log('update:', id, data)
  await navigateTo('/products')
}
</script>
