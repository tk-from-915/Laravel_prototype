<template>
  <form @submit.prevent="onSubmit">
    <div class="post-form__header">
      <h1 class="page-title">{{ title }}</h1>
      <div class="post-form__actions">
        <button type="button" class="btn btn-secondary" @click="emit('cancel')">キャンセル</button>
        <button type="submit" class="btn btn-secondary" @click="form.status = 'draft'">
          下書き保存
        </button>
        <button type="submit" class="btn btn-primary" @click="form.status = 'published'">
          公開する
        </button>
      </div>
    </div>

    <div class="post-form__body">
      <!-- タイトル -->
      <div class="form-group">
        <label class="form-label">商品名 <span class="required">*</span></label>
        <input v-model="form.title" type="text" class="form-input" placeholder="商品名を入力" required />
      </div>

      <!-- 価格 -->
      <div class="form-group">
        <label class="form-label">価格（円）</label>
        <div class="price-input">
          <span class="price-input__symbol">¥</span>
          <input
            v-model.number="form.price"
            type="number"
            min="0"
            step="1"
            class="form-input price-input__field"
            placeholder="0"
          />
        </div>
      </div>

      <!-- カテゴリ -->
      <div class="form-group">
        <label class="form-label">カテゴリ</label>
        <FormCategorySelect v-model="form.categories" />
      </div>

      <!-- サムネイル -->
      <div class="form-group">
        <label class="form-label">サムネイル画像</label>
        <FormImageUpload v-model="form.thumbnail" />
      </div>

      <!-- 本文 -->
      <div class="form-group">
        <label class="form-label">商品説明</label>
        <FormRichTextEditor v-model="form.content" />
      </div>

      <!-- ステータス -->
      <div class="form-group">
        <label class="form-label">公開ステータス</label>
        <div class="status-radio">
          <label class="status-radio__option">
            <input v-model="form.status" type="radio" value="published" />
            <span class="badge badge-published">公開</span>
          </label>
          <label class="status-radio__option">
            <input v-model="form.status" type="radio" value="draft" />
            <span class="badge badge-draft">下書き</span>
          </label>
        </div>
      </div>
    </div>
  </form>
</template>

<script setup lang="ts">
interface ProductFormData {
  title:      string
  price:      number | null
  categories: string[]
  thumbnail:  string | null
  content:    string
  status:     'published' | 'draft'
}

const props = defineProps<{
  title:        string
  initialData?: Partial<ProductFormData>
}>()

const emit = defineEmits<{
  submit: [data: ProductFormData]
  cancel: []
}>()

const form = reactive<ProductFormData>({
  title:      props.initialData?.title      ?? '',
  price:      props.initialData?.price      ?? null,
  categories: props.initialData?.categories ?? [],
  thumbnail:  props.initialData?.thumbnail  ?? null,
  content:    props.initialData?.content    ?? '',
  status:     props.initialData?.status     ?? 'draft',
})

function onSubmit() {
  // TODO: GraphQL mutation で保存処理を実装
  emit('submit', { ...form })
}
</script>

<style lang="scss" scoped>
.post-form {
  &__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
  }

  &__actions {
    display: flex;
    gap: 8px;
  }

  &__body {
    background: $content-bg;
    border-radius: $border-radius;
    box-shadow: 0 1px 4px rgba($primary, 0.08);
    padding: 28px;
  }
}

.required {
  color: #c82333;
  margin-left: 2px;
}

.price-input {
  display: flex;
  align-items: center;
  max-width: 240px;

  &__symbol {
    padding: 8px 10px;
    background: #f8fafa;
    border: 1px solid $border;
    border-right: none;
    border-radius: $border-radius 0 0 $border-radius;
    color: $text-muted;
    font-size: 14px;
  }

  &__field {
    border-radius: 0 $border-radius $border-radius 0;
  }
}

.status-radio {
  display: flex;
  gap: 16px;

  &__option {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;

    input[type='radio'] {
      accent-color: $primary;
      width: 16px;
      height: 16px;
    }
  }
}
</style>
