<template>
  <FormProductForm
    title="商品 新規作成"
    @submit="onSubmit"
    @cancel="navigateTo('/products')"
  />
</template>

<script setup lang="ts">
async function onSubmit(data: object) {
  // TODO: GraphQL mutation で保存処理を実装
  console.log('submit:', data)
  await navigateTo('/products')
}
</script>
