<template>
  <div id="backgroud">
    <h5 id="page_title">商品一覧</h5>
    <!-- TODO: GraphQL から商品カテゴリ一覧を取得して動的に表示する -->
    <div id="menu_wrapper">
      <div class="menu_block">
        <NuxtLink to="/products/1">
          <img src="/images/taniku001.jpeg">
          <p class="menu_title">多肉植物</p>
        </NuxtLink>
      </div>
      <div class="menu_block">
        <NuxtLink to="/products/2">
          <img src="/images/taniku002.jpeg">
          <p class="menu_title">サボテン</p>
        </NuxtLink>
      </div>
      <div class="menu_block">
        <NuxtLink to="/products/3">
          <img src="/images/Benjamin.jpg">
          <p class="menu_title">ベンジャミン</p>
        </NuxtLink>
      </div>
      <div class="menu_block">
        <NuxtLink to="/products/4">
          <img src="/images/monstera.jpg">
          <p class="menu_title">モンステラ</p>
        </NuxtLink>
      </div>
      <div class="menu_block">
        <NuxtLink to="/products/5">
          <img src="/images/kajumaru.jpg">
          <p class="menu_title">カジュマル</p>
        </NuxtLink>
      </div>
      <div class="menu_block">
        <NuxtLink to="/products/6">
          <img src="/images/Terrarium.jpg">
          <p class="menu_title">テラリウム</p>
        </NuxtLink>
      </div>
    </div>
  </div>
</template>
