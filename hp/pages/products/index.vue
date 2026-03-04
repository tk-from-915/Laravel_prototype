<template>
  <CommonPageLayout title="商品一覧">
    <!-- TODO: GraphQL からカテゴリ一覧を取得して動的に表示する -->
    <div class="category-grid">
      <NuxtLink
        v-for="cat in categories"
        :key="cat.id"
        :to="`/products/category/${cat.id}`"
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
const categories = [
  { id: 'foliage',   name: '観葉植物',              image: '/images/monstera.jpg'   },
  { id: 'succulent', name: '多肉植物',              image: '/images/taniku001.jpeg' },
  { id: 'bonsai',    name: '盆栽',                  image: '/images/tree2.jpg'      },
  { id: 'flower',    name: '生花',                  image: null                     },
  { id: 'caudex',    name: '塊根植物',              image: '/images/taniku002.jpeg' },
  { id: 'epiphyte',  name: '着生植物',              image: null                     },
  { id: 'tropical',  name: '熱帯植物',              image: '/images/Benjamin.jpg'   },
  { id: 'terrarium', name: 'テラリウム・パルダリウム', image: '/images/Terrarium.jpg'  },
  { id: 'goods',     name: 'グッズ',                image: null                     },
]
</script>

<style scoped>
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
