<template>
  <NuxtLink
    v-if="to"
    :to="to"
    class="app-btn"
    :class="[`app-btn--${variant}`, { 'app-btn--disabled': disabled }]"
  >
    <slot />
  </NuxtLink>
  <button
    v-else
    :type="type"
    :disabled="disabled"
    class="app-btn"
    :class="[`app-btn--${variant}`, { 'app-btn--disabled': disabled }]"
  >
    <slot />
  </button>
</template>

<script setup lang="ts">
withDefaults(defineProps<{
  variant?: 'green' | 'red'
  disabled?: boolean
  type?: 'button' | 'submit'
  to?: string
}>(), {
  variant: 'green',
  disabled: false,
  type: 'button',
})
</script>

<style scoped>
.app-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto;
  padding: 8px 40px;
  font-size: 24px;
  font-family: 'Ribeye';
  color: #f0f0f0;
  border: 2px solid transparent;
  cursor: pointer;
  text-decoration: none;
  transition: opacity 0.15s;
  box-sizing: border-box;
}

/* 緑（通常） */
.app-btn--green {
  background-color: #007575;
}

/* 緑（disabled） */
.app-btn--green.app-btn--disabled {
  background-color: rgba(0, 117, 117, 0.40);
  border-color: #007575;
  cursor: not-allowed;
}

/* 赤（通常） */
.app-btn--red {
  background-color: rgba(200, 35, 51, 0.85);
}

/* 赤（disabled） */
.app-btn--red.app-btn--disabled {
  background-color: rgba(250, 7, 7, 0.39);
  border-color: rgba(200, 35, 51, 0.85);
  cursor: not-allowed;
}

.app-btn:not(.app-btn--disabled):hover {
  opacity: 0.85;
}
</style>
