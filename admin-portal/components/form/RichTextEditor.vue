<template>
  <div class="editor">
    <div v-if="editor" class="editor__toolbar">
      <button
        v-for="btn in toolbarButtons"
        :key="btn.label"
        type="button"
        class="editor__toolbar-btn"
        :class="{ 'editor__toolbar-btn--active': btn.isActive?.() }"
        :title="btn.label"
        @click="btn.action"
      >
        {{ btn.icon }}
      </button>
    </div>
    <EditorContent class="editor__content" :editor="editor" />
  </div>
</template>

<script setup lang="ts">
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Image from '@tiptap/extension-image'
import Placeholder from '@tiptap/extension-placeholder'

const props = defineProps<{ modelValue: string }>()
const emit = defineEmits<{ 'update:modelValue': [string] }>()

const editor = useEditor({
  content: props.modelValue,
  extensions: [
    StarterKit,
    Image,
    Placeholder.configure({ placeholder: '本文を入力してください...' }),
  ],
  onUpdate: ({ editor }) => {
    emit('update:modelValue', editor.getHTML())
  },
})

const toolbarButtons = computed(() => [
  {
    label: '太字',
    icon: 'B',
    action: () => editor.value?.chain().focus().toggleBold().run(),
    isActive: () => editor.value?.isActive('bold') ?? false,
  },
  {
    label: 'イタリック',
    icon: 'I',
    action: () => editor.value?.chain().focus().toggleItalic().run(),
    isActive: () => editor.value?.isActive('italic') ?? false,
  },
  {
    label: '見出し1',
    icon: 'H1',
    action: () => editor.value?.chain().focus().toggleHeading({ level: 1 }).run(),
    isActive: () => editor.value?.isActive('heading', { level: 1 }) ?? false,
  },
  {
    label: '見出し2',
    icon: 'H2',
    action: () => editor.value?.chain().focus().toggleHeading({ level: 2 }).run(),
    isActive: () => editor.value?.isActive('heading', { level: 2 }) ?? false,
  },
  {
    label: '箇条書き',
    icon: '≡',
    action: () => editor.value?.chain().focus().toggleBulletList().run(),
    isActive: () => editor.value?.isActive('bulletList') ?? false,
  },
  {
    label: '番号リスト',
    icon: '①',
    action: () => editor.value?.chain().focus().toggleOrderedList().run(),
    isActive: () => editor.value?.isActive('orderedList') ?? false,
  },
  {
    label: '区切り線',
    icon: '—',
    action: () => editor.value?.chain().focus().setHorizontalRule().run(),
    isActive: () => false,
  },
])

onBeforeUnmount(() => editor.value?.destroy())
</script>

<style lang="scss" scoped>
.editor {
  border: 1px solid $border;
  border-radius: $border-radius;
  overflow: hidden;

  &__toolbar {
    display: flex;
    flex-wrap: wrap;
    gap: 2px;
    padding: 6px 8px;
    background: #f8fafa;
    border-bottom: 1px solid $border;
  }

  &__toolbar-btn {
    padding: 4px 8px;
    border: 1px solid transparent;
    border-radius: $border-radius;
    background: none;
    cursor: pointer;
    font-size: 13px;
    font-weight: bold;
    color: $text;
    min-width: 32px;

    &:hover {
      background: $primary-light;
      border-color: $border;
    }

    &--active {
      background: $primary;
      color: #fff;
    }
  }

  &__content {
    padding: 12px 16px;
    min-height: 280px;
    background: #fff;

    :deep(.ProseMirror) {
      outline: none;
      font-size: 15px;
      line-height: 1.7;
      color: $text;

      p.is-editor-empty:first-child::before {
        content: attr(data-placeholder);
        color: $text-muted;
        pointer-events: none;
        float: left;
        height: 0;
      }

      h1 { font-size: 1.6em; margin: 0.8em 0 0.4em; }
      h2 { font-size: 1.3em; margin: 0.8em 0 0.4em; }
      p  { margin: 0.4em 0; }
      ul, ol { padding-left: 1.4em; margin: 0.4em 0; }
      hr { border: none; border-top: 1px solid $border; margin: 1em 0; }
      img { max-width: 100%; border-radius: $border-radius; }
    }
  }
}
</style>
