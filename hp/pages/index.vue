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
        <li v-if="newsLoading" class="news_list">読み込み中...</li>
        <li
          v-for="post in latestNews"
          :key="post.id"
          class="news_list"
        >
          {{ formatNewsDate(post.published_at ?? post.created_at) }}
          <NuxtLink :to="`/blog/${post.id}`" style="color: inherit;">{{ post.title }}</NuxtLink>
        </li>
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
import { useQuery } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const LATEST_NEWS = gql`
  query LatestNews {
    posts(type: "news", status: "published", page: 1, perPage: 8) {
      data { id title published_at created_at }
    }
  }
`

const { result: newsResult, loading: newsLoading } = useQuery(LATEST_NEWS)
const latestNews = computed(() => newsResult.value?.posts.data ?? [])

function formatNewsDate(dt: string | null) {
  if (!dt) return ''
  return new Date(dt).toLocaleDateString('ja-JP', { year: 'numeric', month: '2-digit', day: '2-digit' }).replace(/\//g, '/')
}

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
