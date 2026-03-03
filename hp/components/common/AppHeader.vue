<script setup lang="ts">
const { isNavOpen, toggleNav, closeNav } = useNavigation()
</script>

<template>
  <div id="triangle" :class="{ 'nav-open': isNavOpen }">
    <div id="hamburger_menu" @click="toggleNav">
      <span class="hamburger__line hamburger__line1"></span>
      <span class="hamburger__line hamburger__line2"></span>
      <span class="hamburger__line hamburger__line3"></span>
    </div>
    <nav id="sidebar">
      <ul id="sidebar_list">
        <li class="sidebar__item"><NuxtLink to="/" @click="closeNav">トップ</NuxtLink></li>
        <li class="sidebar__item"><NuxtLink to="/aboutUs" @click="closeNav">私たちについて</NuxtLink></li>
        <li class="sidebar__item"><NuxtLink to="/company" @click="closeNav">会社情報</NuxtLink></li>
        <li class="sidebar__item"><NuxtLink to="/products" @click="closeNav">商品一覧</NuxtLink></li>
        <li class="sidebar__item"><NuxtLink to="/blog" @click="closeNav">News</NuxtLink></li>
        <li class="sidebar__item"><NuxtLink to="/blog" @click="closeNav">ブログ</NuxtLink></li>
        <li class="sidebar__item"><NuxtLink to="/contact" @click="closeNav">お問い合わせ</NuxtLink></li>
        <li class="sidebar__item"><NuxtLink to="/recruit" @click="closeNav">採用情報</NuxtLink></li>
        <li class="sidebar__item"><NuxtLink to="/privacyPolicy" @click="closeNav">プライバシーポリシー</NuxtLink></li>
      </ul>
    </nav>
    <div id="gray_backgroud" @click="closeNav"></div>
  </div>
</template>
