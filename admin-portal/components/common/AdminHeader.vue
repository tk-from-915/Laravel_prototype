<template>
  <header class="admin-header">
    <div class="admin-header__user" @click="toggleMenu">
      <span class="admin-header__name">{{ currentUser?.name ?? 'User' }} ▼</span>
      <div v-if="menuOpen" class="admin-header__menu">
        <button class="admin-header__menu-item" @click.stop="handleLogout">ログアウト</button>
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
import { useMutation } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const { currentUser, clearAuth } = useAuth()
const menuOpen = ref(false)

const LOGOUT_MUTATION = gql`mutation Logout { logout }`
const { mutate: logoutMutation } = useMutation(LOGOUT_MUTATION)

function toggleMenu() {
  menuOpen.value = !menuOpen.value
}

async function handleLogout() {
  try { await logoutMutation() } catch {}
  clearAuth()
  navigateTo('/login')
}
</script>

<style lang="scss" scoped>
.admin-header {
  height: 40px;
  background: rgba($primary, 0.4);
  display: flex;
  align-items: center;
  justify-content: flex-end;
  padding: 0 20px;

  &__user {
    position: relative;
    cursor: pointer;
  }

  &__name {
    color: #f0f0f0;
    font-size: 18px;
    font-family: inherit;
  }

  &__menu {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    background: #fff;
    border: 1px solid $border;
    border-radius: $border-radius;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    z-index: 100;
    min-width: 120px;
  }

  &__menu-item {
    display: block;
    width: 100%;
    padding: 10px 16px;
    background: none;
    border: none;
    text-align: left;
    font-size: 14px;
    color: $text;
    cursor: pointer;
    font-family: inherit;

    &:hover {
      background: rgba($primary, 0.08);
      color: $primary;
    }
  }
}
</style>
