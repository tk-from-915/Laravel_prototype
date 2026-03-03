<template>
  <div class="page-wrapper">
    <h5 id="page_title">{{ title }}</h5>
    <div id="content">
      <slot />
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{ title: string }>()
</script>
