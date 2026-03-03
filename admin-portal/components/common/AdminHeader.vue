<template>
  <header class="admin-header">
    <!-- TODO: 認証実装後にログインユーザー名を表示 -->
    <button class="admin-header__user">User ▼</button>
  </header>
</template>

<style lang="scss" scoped>
.admin-header {
  height: 40px;
  background: rgba($primary, 0.4);
  display: flex;
  align-items: center;
  justify-content: flex-end;
  padding: 0 20px;

  &__user {
    background: none;
    border: none;
    color: #f0f0f0;
    font-size: 18px;
    cursor: pointer;
    font-family: inherit;
  }
}
</style>
