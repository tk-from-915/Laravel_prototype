<template>
  <aside class="sidebar">
    <div class="sidebar__brand">
      <span class="sidebar__brand-logo">LHG</span>
      <span class="sidebar__brand-label">Admin</span>
    </div>

    <nav class="sidebar__nav">
      <ul class="sidebar__menu">
        <li>
          <NuxtLink to="/" class="sidebar__item" exact-active-class="sidebar__item--active">
            Home
          </NuxtLink>
        </li>
        <li>
          <!-- TODO: 認証実装後にユーザー管理ページを追加 -->
          <NuxtLink to="/users" class="sidebar__item" active-class="sidebar__item--active">
            user
          </NuxtLink>
        </li>
        <li>
          <NuxtLink to="/products" class="sidebar__item" active-class="sidebar__item--active">
            Products
          </NuxtLink>
        </li>
        <li>
          <NuxtLink to="/news" class="sidebar__item" active-class="sidebar__item--active">
            News
          </NuxtLink>
        </li>
        <li>
          <NuxtLink to="/blog" class="sidebar__item" active-class="sidebar__item--active">
            Blog
          </NuxtLink>
        </li>
        <li>
          <!-- TODO: 静的ページ管理を実装後に有効化 -->
          <NuxtLink to="/pages" class="sidebar__item" active-class="sidebar__item--active">
            Page
          </NuxtLink>
        </li>
        <li>
          <NuxtLink to="/contacts" class="sidebar__item" active-class="sidebar__item--active">
            Contact &amp; reqruit
          </NuxtLink>
        </li>
      </ul>
    </nav>

    <div class="sidebar__footer">
      <!-- TODO: 認証実装後にログアウト処理を追加 -->
      <button class="sidebar__logout" disabled>ログアウト</button>
    </div>
  </aside>
</template>

<style lang="scss" scoped>
.sidebar {
  width: $sidebar-width;
  height: 100vh;
  background-color: $sidebar-bg;
  position: fixed;
  top: 0;
  left: 0;
  display: flex;
  flex-direction: column;
  z-index: 100;
  overflow-y: auto;

  &__brand {
    padding: 24px 20px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    display: flex;
    align-items: baseline;
    gap: 8px;

    &-logo {
      font-size: 24px;
      font-weight: bold;
      color: #f0f0f0;
      letter-spacing: 2px;
    }

    &-label {
      font-size: 13px;
      color: rgba(240, 240, 240, 0.7);
      letter-spacing: 1px;
    }
  }

  &__nav {
    flex: 1;
    padding: 8px 0;
  }

  &__menu {
    padding: 0;
  }

  &__item {
    display: block;
    padding: 12px 24px;
    color: $sidebar-text;
    font-size: 22px;
    transition: background-color 0.15s;

    &:hover {
      background-color: $sidebar-hover;
    }

    &--active {
      background-color: $sidebar-active-bg;
      color: $sidebar-active-text;
    }
  }

  &__footer {
    padding: 16px 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.15);
  }

  &__logout {
    width: 100%;
    padding: 8px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: $border-radius;
    color: $sidebar-text;
    font-size: 13px;
    cursor: not-allowed;
    opacity: 0.6;
  }
}
</style>
