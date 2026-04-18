<template>
  <div class="category-select">
    <span v-if="loading" class="category-select__loading">読み込み中...</span>
    <label
      v-for="cat in categories"
      v-else
      :key="cat.slug"
      class="category-select__item"
      :class="{ 'category-select__item--checked': modelValue.includes(cat.slug) }"
    >
      <input
        type="checkbox"
        :value="cat.slug"
        :checked="modelValue.includes(cat.slug)"
        @change="toggle(cat.slug)"
      />
      <span>{{ cat.name }}</span>
    </label>
  </div>
</template>

<script setup lang="ts">
import { useQuery } from '@vue/apollo-composable'
import { gql } from '@apollo/client/core'

const LIST_CATEGORIES = gql`
  query CategorySelectList {
    categories { slug name }
  }
`

const props = defineProps<{ modelValue: string[] }>()
const emit = defineEmits<{ 'update:modelValue': [string[]] }>()

const { result, loading } = useQuery(LIST_CATEGORIES)
const categories = computed(() => result.value?.categories ?? [])

function toggle(slug: string) {
  const next = props.modelValue.includes(slug)
    ? props.modelValue.filter((v) => v !== slug)
    : [...props.modelValue, slug]
  emit('update:modelValue', next)
}
</script>

<style lang="scss" scoped>
.category-select {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 8px;

  &__loading {
    color: $text-muted;
    font-size: 13px;
  }

  &__item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border: 1px solid $border;
    border-radius: $border-radius;
    cursor: pointer;
    font-size: 14px;
    color: $text;
    transition: border-color 0.15s, background 0.15s;

    input[type='checkbox'] {
      accent-color: $primary;
      width: 15px;
      height: 15px;
      flex-shrink: 0;
    }

    &:hover {
      border-color: $primary;
      background: rgba($primary, 0.03);
    }

    &--checked {
      border-color: $primary;
      background: $primary-light;
      color: $primary-dark;
    }
  }
}
</style>
