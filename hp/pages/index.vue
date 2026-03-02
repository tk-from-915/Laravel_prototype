<template>
  <div id="container">
    <div id="top_page1" class="toppage_block">
      <div id="top_fonts">
        <p id="top_title">Little Healing Green</p>
        <p id="sub_title">暮らしにすてきな癒しを</p>
      </div>
    </div>

    <div id="top_page2" class="toppage_block">
      <p id="page2_title1">忙しい毎日に<br>癒しのひとときを</p>
      <div id="top_image2">
        <img src="/images/tree2.jpg">
      </div>
      <div id="page2_rightblock">
        <p id="page2_title2">学業やお仕事、家事や育児。<br>毎日がんばるあなたへ。</p>
        <p id="page2_title3">そんな毎日にちょっとした癒しを<br>プレゼントしませんか？</p>
      </div>
      <div class="green_section_topdiagonal"></div>
    </div>
    <div id="top_page3" class="toppage_block">
      <h1>News</h1>
      <ul id="news_lists">
        <li class="news_list">2020/12/15　クリスマスリース販売中です。</li>
        <li class="news_list">2020/10/31　ハロウィンに使われる植物とは？</li>
        <li class="news_list">2020/08/12　真夏でも葉焼けしない方法</li>
        <li class="news_list">2020/06/06　梅雨の時期にぴったりの植物はコレ！</li>
        <li class="news_list">2020/04/01　卒業式＆入学式にはこの花を</li>
        <li class="news_list">2020/03/03　桃の花の時期になりました。</li>
        <li class="news_list">2020/02/01　今年のバレンタインには♡</li>
        <li class="news_list">2020/01/01　あけましておめでとうございます。</li>
      </ul>
      <button class="green_button toppage_button">
        <NuxtLink to="/blog" class="whitelink">More  →</NuxtLink>
      </button>
    </div>

    <div id="top_page4" class="toppage_block">
      <h1>Green</h1>
      <p>当店で扱っている商品をご紹介</p>
      <div id="toppage_menus">
        <div class="menu_block">
          <h5>Foliage plant</h5>
          <img src="/images/kajumaru.jpg">
        </div>
        <div class="menu_block">
          <h5>Succulents</h5>
          <img src="/images/taniku001.jpeg">
        </div>
        <div class="menu_block">
          <h5>Terrarium</h5>
          <img src="/images/Terrarium.jpg">
        </div>
      </div>
      <button class="green_button toppage_button">
        <NuxtLink to="/products" class="whitelink">More  →</NuxtLink>
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
// ScrollReveal はクライアント側のみで動作
onMounted(async () => {
  const ScrollReveal = (await import('scrollreveal')).default
  const sr = ScrollReveal({
    container: document.querySelector('#container'),
    distance: '40px',
    origin: 'bottom',
    duration: 2000,
    easing: 'ease',
    reset: false,
  })
  sr.reveal('#page2_title1',   { delay: 100 })
  sr.reveal('#page2_rightblock', { delay: 700 })
  sr.reveal('#top_image2',     { delay: 1700 })
})
</script>
