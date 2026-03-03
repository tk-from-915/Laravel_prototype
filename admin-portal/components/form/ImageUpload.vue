<template>
  <div class="image-upload">
    <div v-if="preview" class="image-upload__preview">
      <img :src="preview" alt="サムネイル" />
      <button type="button" class="image-upload__remove" @click="remove">✕ 削除</button>
    </div>
    <label v-else class="image-upload__area">
      <input
        ref="inputRef"
        type="file"
        accept="image/*"
        class="image-upload__input"
        @change="onFileChange"
      />
      <span class="image-upload__icon">＋</span>
      <span class="image-upload__label">画像をアップロード</span>
      <span class="image-upload__hint">PNG / JPG / WEBP</span>
    </label>
  </div>
</template>

<script setup lang="ts">
const props = defineProps<{ modelValue: string | null }>()
const emit = defineEmits<{ 'update:modelValue': [string | null] }>()

const preview = ref<string | null>(props.modelValue)

function onFileChange(e: Event) {
  const file = (e.target as HTMLInputElement).files?.[0]
  if (!file) return
  // TODO: GraphQL / Laravel Storage への実際のアップロード処理を追加
  preview.value = URL.createObjectURL(file)
  emit('update:modelValue', preview.value)
}

function remove() {
  preview.value = null
  emit('update:modelValue', null)
}
</script>

<style lang="scss" scoped>
.image-upload {
  &__preview {
    position: relative;
    display: inline-block;

    img {
      max-width: 100%;
      max-height: 240px;
      border-radius: $border-radius;
      border: 1px solid $border;
      display: block;
    }
  }

  &__remove {
    margin-top: 8px;
    padding: 4px 12px;
    background: rgba(200, 35, 51, 0.1);
    border: 1px solid rgba(200, 35, 51, 0.3);
    border-radius: $border-radius;
    color: #c82333;
    font-size: 12px;
    cursor: pointer;
  }

  &__area {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    width: 100%;
    min-height: 140px;
    border: 2px dashed $border;
    border-radius: $border-radius;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;

    &:hover {
      border-color: $primary;
      background: rgba($primary, 0.03);
    }
  }

  &__input {
    display: none;
  }

  &__icon {
    font-size: 28px;
    color: $text-muted;
  }

  &__label {
    font-size: 14px;
    color: $text;
  }

  &__hint {
    font-size: 12px;
    color: $text-muted;
  }
}
</style>
