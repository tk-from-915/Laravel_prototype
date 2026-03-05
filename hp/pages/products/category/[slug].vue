<template>
  <CommonPageLayout :title="category?.name ?? slug">
    <div v-if="loading" class="loading-text">読み込み中...</div>
    <template v-else>
      <div v-if="products.length === 0" class="loading-text">商品がありません</div>
      <div v-else class="product-grid">
        <NuxtLink
          v-for="product in products"
          :key="product.id"
          :to="`/products/${product.id}`"
          class="product-card"
        >
          <div class="product-card__image">
            <span class="product-card__initial">{{ product.name[0] }}</span>
          </div>
          <p class="product-card__name">{{ product.name }}</p>
          <p class="product-card__price">¥{{ product.price.toLocaleString() }}</p>
        </NuxtLink>
      </div>
    </template>
    <div class="back-link">
      <NuxtLink to="/products">← 商品カテゴリ一覧</NuxtLink>
    </div>
  </CommonPageLayout>
</template>

<script setup lang="ts">
import { useQuery } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const { slug } = useRoute().params as { slug: string }

const CATEGORIES = gql`
  query Categories {
    categories { id slug name }
  }
`

const PRODUCTS_BY_CATEGORY = gql`
  query ProductsByCategory($categoryId: Int) {
    products(categoryId: $categoryId, status: "active", page: 1, perPage: 50) {
      data { id name price }
    }
  }
`

const { result: catResult } = useQuery(CATEGORIES)
const category = computed(() =>
  catResult.value?.categories?.find((c: any) => c.slug === slug) ?? null,
)

const { result: productsResult, loading } = useQuery(
  PRODUCTS_BY_CATEGORY,
  computed(() => ({ categoryId: category.value ? Number(category.value.id) : null })),
  computed(() => ({ enabled: !!category.value, fetchPolicy: 'network-only' })),
)

const products = computed(() => productsResult.value?.products.data ?? [])
</script>

<style scoped>
.loading-text {
  text-align: center;
  padding: 40px;
  color: #a8a8a8;
}

.product-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  margin-bottom: 32px;
}

.product-card {
  display: block;
  text-decoration: none;
  text-align: center;
  color: #a8a8a8;
  transition: opacity 0.2s;
}

.product-card:hover {
  opacity: 0.75;
}

.product-card__image {
  width: 100%;
  aspect-ratio: 1;
  max-width: 160px;
  margin: 0 auto 10px;
  background-color: #CDF4F4;
  display: flex;
  align-items: center;
  justify-content: center;
}

.product-card__initial {
  font-size: 48px;
  color: #007575;
}

.product-card__name {
  font-size: 16px;
  margin: 4px 0 2px;
}

.product-card__price {
  font-size: 14px;
  color: #007575;
  font-weight: bold;
}

.back-link {
  margin-top: 16px;
  font-size: 14px;
}

.back-link a {
  color: #007575;
  text-decoration: none;
}

.back-link a:hover {
  text-decoration: underline;
}
</style>
