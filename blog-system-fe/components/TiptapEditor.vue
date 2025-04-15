<!-- components/TiptapEditor.vue -->
<template>
    <div class="border p-2 rounded min-h-[200px] bg-white">
      <EditorContent :editor="editor" />
    </div>
  </template>
  
  <script setup>
  import { EditorContent, useEditor } from '@tiptap/vue-3'
  import StarterKit from '@tiptap/starter-kit'
  import Image from '@tiptap/extension-image'
  import { ImageDrop } from '~/plugins/tiptap/ImageDrop'
  
  const props = defineProps({
    modelValue: String,
  })
  const emit = defineEmits(['update:modelValue'])
  
  const editor = useEditor({
    content: props.modelValue,
    extensions: [StarterKit, Image, ImageDrop],
    onUpdate({ editor }) {
      emit('update:modelValue', editor.getHTML())
    },
  })
  </script>
  