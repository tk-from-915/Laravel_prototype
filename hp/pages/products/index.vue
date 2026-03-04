<template>
  <CommonPageLayout title="商品一覧">
    <div v-if="loading" class="loading-text">読み込み中...</div>
    <div v-else class="category-grid">
      <NuxtLink
        v-for="cat in categoriesWithImages"
        :key="cat.id"
        :to="`/products/category/${cat.slug}`"
        class="category-card"
      >
        <div
          class="category-card__image"
          :style="cat.image ? `background-image: url(${cat.image})` : ''"
        >
          <span v-if="!cat.image" class="category-card__initial">{{ cat.name[0] }}</span>
        </div>
        <p class="category-card__name">{{ cat.name }}</p>
      </NuxtLink>
    </div>
  </CommonPageLayout>
</template>

<script setup lang="ts">
import { useQuery } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const CATEGORIES = gql`
  query Categories {
    categories { id slug name }
  }
`

const CATEGORY_IMAGES: Record<string, string> = {
  foliage:   '/images/monstera.jpg',
  succulent: '/images/taniku001.jpeg',
  bonsai:    '/images/tree2.jpg',
  caudex:    '/images/taniku002.jpeg',
  tropical:  '/images/Benjamin.jpg',
  terrarium: '/images/Terrarium.jpg',
}

const { result, loading } = useQuery(CATEGORIES)

const categoriesWithImages = computed(() =>
  (result.value?.categories ?? []).map((cat: any) => ({
    ...cat,
    image: CATEGORY_IMAGES[cat.slug] ?? null,
  })),
)
</script>

<style scoped>
.loading-text {
  text-align: center;
  padding: 40px;
  color: #a8a8a8;
}

.category-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  margin-bottom: 40px;
}

.category-card {
  display: block;
  text-decoration: none;
  text-align: center;
  color: #a8a8a8;
  transition: opacity 0.2s;
}

.category-card:hover {
  opacity: 0.75;
}

.category-card__image {
  width: 100%;
  aspect-ratio: 1;
  max-width: 160px;
  margin: 0 auto 10px;
  background-color: #CDF4F4;
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: center;
  justify-content: center;
}

.category-card__initial {
  font-size: 48px;
  color: #007575;
}

.category-card__name {
  font-size: 18px;
}
</style>
