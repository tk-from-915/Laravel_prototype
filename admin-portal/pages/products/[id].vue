<template>
  <div v-if="loading" class="page-loading">読み込み中...</div>
  <FormProductForm
    v-else-if="product"
    title="商品 編集"
    :initial-data="initialData"
    @submit="onSubmit"
    @cancel="navigateTo('/products')"
  />
</template>

<script setup lang="ts">
import { useQuery, useMutation } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const { id } = useRoute().params as { id: string }

const GET_PRODUCT = gql`
  query GetProduct($id: ID!) {
    product(id: $id) { id name description price status categories { id slug } }
  }
`

const CATEGORIES = gql`
  query Categories {
    categories { id slug }
  }
`

const UPDATE_PRODUCT = gql`
  mutation UpdateProduct($id: ID!, $name: String, $description: String, $price: Int, $status: String, $categoryIds: [Int!]) {
    updateProduct(id: $id, name: $name, description: $description, price: $price, status: $status, categoryIds: $categoryIds) { id }
  }
`

const { result, loading } = useQuery(GET_PRODUCT, { id })
const { result: catResult } = useQuery(CATEGORIES)
const product = computed(() => result.value?.product ?? null)

const initialData = computed(() =>
  product.value
    ? {
        title: product.value.name,
        price: product.value.price,
        categories: product.value.categories.map((c: any) => c.slug),
        thumbnail: null,
        content: product.value.description ?? '',
        status: product.value.status === 'active' ? 'published' : 'draft',
      }
    : undefined,
)

const { mutate: updateProduct } = useMutation(UPDATE_PRODUCT)

async function onSubmit(data: {
  title: string
  price: number | null
  categories: string[]
  thumbnail: string | null
  content: string
  status: 'published' | 'draft'
}) {
  const allCategories = catResult.value?.categories ?? []
  const categoryIds = data.categories
    .map((slug: string) => allCategories.find((c: any) => c.slug === slug)?.id)
    .filter((id: any) => id != null)
    .map(Number)

  await updateProduct({
    id,
    name: data.title,
    description: data.content,
    price: data.price ?? 0,
    status: data.status === 'published' ? 'active' : 'inactive',
    categoryIds,
  })
  await navigateTo('/products')
}
</script>

<style lang="scss" scoped>
.page-loading {
  padding: 40px;
  text-align: center;
  color: $text-muted;
}
</style>
