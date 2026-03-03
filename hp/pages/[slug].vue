<template>
  <CommonPageLayout :title="slug">
    <!-- TODO: GraphQL から slug に対応するページデータを取得して動的に表示する -->
    <p>ページを準備中です。</p>
  </CommonPageLayout>
</template>

<script setup lang="ts">
const { slug } = useRoute().params as { slug: string }
</script>
