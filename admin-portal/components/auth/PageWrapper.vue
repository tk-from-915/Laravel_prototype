<template>
  <div class="auth-shell">
    <header class="auth-shell__header">
      <span class="auth-shell__brand">
        Little Healing Green&nbsp;&nbsp;<span class="auth-shell__page-name">{{ title }}</span>
      </span>
      <NuxtLink v-if="actionTo" :to="actionTo" class="auth-shell__action">
        {{ actionLabel }}
      </NuxtLink>
    </header>

    <main class="auth-shell__body">
      <slot />
    </main>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  title: string
  actionLabel?: string
  actionTo?: string
}>()
</script>

<style lang="scss" scoped>
.auth-shell {
  min-height: 100vh;
  background-color: #f5f5f5;
  display: flex;
  flex-direction: column;

  &__header {
    background-color: rgba($primary, 0.4);
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 24px;
    flex-shrink: 0;
  }

  &__brand {
    color: #fff;
    font-size: 18px;
    font-weight: bold;
    letter-spacing: 0.5px;
  }

  &__page-name {
    font-weight: bold;
  }

  &__action {
    border: 1px solid #fff;
    color: #fff;
    padding: 5px 16px;
    font-size: 14px;
    border-radius: 3px;
    text-decoration: none;
    transition: background-color 0.15s;

    &:hover {
      background-color: rgba(255, 255, 255, 0.2);
    }
  }

  &__body {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 64px;
    padding-bottom: 40px;
  }
}
</style>
