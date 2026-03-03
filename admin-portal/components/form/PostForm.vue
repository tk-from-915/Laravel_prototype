<template>
  <form @submit.prevent="onSubmit">
    <div class="post-form__header">
      <h1 class="page-title">{{ title }}</h1>
      <div class="post-form__actions">
        <button type="button" class="btn btn-secondary" @click="emit('cancel')">キャンセル</button>
        <button type="submit" name="action" value="draft" class="btn btn-secondary" @click="form.status = 'draft'">
          下書き保存
        </button>
        <button type="submit" name="action" value="publish" class="btn btn-primary" @click="form.status = 'published'">
          公開する
        </button>
      </div>
    </div>

    <div class="post-form__body">
      <!-- タイトル -->
      <div class="form-group">
        <label class="form-label">タイトル <span class="required">*</span></label>
        <input v-model="form.title" type="text" class="form-input" placeholder="タイトルを入力" required />
      </div>

      <!-- 本文 -->
      <div class="form-group">
        <label class="form-label">本文</label>
        <FormRichTextEditor v-model="form.content" />
      </div>

      <!-- サムネイル -->
      <div class="form-group">
        <label class="form-label">サムネイル画像</label>
        <FormImageUpload v-model="form.thumbnail" />
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
interface PostFormData {
  title: string
  content: string
  thumbnail: string | null
  status: 'published' | 'draft'
}

const props = defineProps<{
  title: string
  initialData?: Partial<PostFormData>
}>()

const emit = defineEmits<{
  submit: [data: PostFormData]
  cancel: []
}>()

const form = reactive<PostFormData>({
  title: props.initialData?.title ?? '',
  content: props.initialData?.content ?? '',
  thumbnail: props.initialData?.thumbnail ?? null,
  status: props.initialData?.status ?? 'draft',
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
