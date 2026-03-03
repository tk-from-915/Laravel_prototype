<template>
  <div class="category-select">
    <label
      v-for="cat in PRODUCT_CATEGORIES"
      :key="cat.id"
      class="category-select__item"
      :class="{ 'category-select__item--checked': modelValue.includes(cat.id) }"
    >
      <input
        type="checkbox"
        :value="cat.id"
        :checked="modelValue.includes(cat.id)"
        @change="toggle(cat.id)"
      />
      <span>{{ cat.name }}</span>
    </label>
  </div>
</template>

<script setup lang="ts">
import { PRODUCT_CATEGORIES } from '~/utils/categories'
import type { CategoryId } from '~/utils/categories'

const props = defineProps<{ modelValue: CategoryId[] }>()
const emit = defineEmits<{ 'update:modelValue': [CategoryId[]] }>()

function toggle(id: CategoryId) {
  const next = props.modelValue.includes(id)
    ? props.modelValue.filter((v) => v !== id)
    : [...props.modelValue, id]
  emit('update:modelValue', next)
}
</script>

<style lang="scss" scoped>
.category-select {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 8px;

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
