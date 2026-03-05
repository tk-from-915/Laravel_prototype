<template>
  <FormProductForm
    title="商品 新規作成"
    @submit="onSubmit"
    @cancel="navigateTo('/products')"
  />
</template>

<script setup lang="ts">
import { useQuery, useMutation } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const CATEGORIES = gql`
  query Categories {
    categories { id slug }
  }
`

const CREATE_PRODUCT = gql`
  mutation CreateProduct($name: String!, $description: String, $price: Int!, $status: String, $categoryIds: [Int!]) {
    createProduct(name: $name, description: $description, price: $price, status: $status, categoryIds: $categoryIds) { id }
  }
`

const { result: catResult } = useQuery(CATEGORIES)
const { mutate: createProduct } = useMutation(CREATE_PRODUCT)

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

  await createProduct({
    name: data.title,
    description: data.content,
    price: data.price ?? 0,
    status: data.status === 'published' ? 'active' : 'inactive',
    categoryIds,
  })
  await navigateTo('/products')
}
</script>
