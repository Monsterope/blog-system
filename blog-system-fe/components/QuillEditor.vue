<template>
    <div>
      <div ref="editorContainer" class="quill-editor" />
    </div>
  </template>
  
  <script setup lang="ts">
  import { onMounted, ref, defineEmits, watch } from 'vue'
  import Quill from 'quill'
  import 'quill/dist/quill.snow.css'
  
  const props = defineProps({
    modelValue: {
      type: String,
      default: ''
    },
    disabled: {
      type: Boolean,
      default: true
    },
  })
  const emit = defineEmits(['update:modelValue'])
  
  const editorContainer = ref<HTMLDivElement | null>(null)
  let quill: Quill | null = null
  
  onMounted(() => {
    if (editorContainer.value) {
      quill = new Quill(editorContainer.value, {
        theme: 'snow',
        readOnly: props.disabled,
        modules: props.disabled
          ? { toolbar: false }
          : {
              toolbar: [
                [{ header: [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                ['image', 'code-block'],
                ['clean']
              ],
              clipboard: {
                matchers: [
                  ['img', () => {
                    return null // ignore all <img> from paste
                  }]
                ], // เคลียร์ matcher พวก <img> อัตโนมัติ (ถ้ามี)
              },
            }
      })
  
      // ตั้งค่าค่าเริ่มต้น
      quill.root.innerHTML = props.modelValue
  
      // อัปเดต modelValue ทุกครั้งที่มีการเปลี่ยน
      quill.on('text-change', () => {
        emit('update:modelValue', quill!.root.innerHTML)
      })

      // Drag & Drop Image Upload
      quill.root.addEventListener('drop', async (event) => {
        event.preventDefault();

        // ตรวจสอบว่า event มีไฟล์หรือไม่
        const files = event.dataTransfer?.files;
        if (files?.length) {
          const file = files[0];
          if (file && /image/i.test(file.type)) {
            const formData = new FormData();
            formData.append('image', file);

            try {
              // อัปโหลดไปยัง API ของคุณ
              const { apiUpload } = useCallApi();
              const res = await apiUpload('/upload', {
                method: 'POST',
                body: formData,
                headers: {
                  'Authorization': `Bearer ${localStorage.getItem('token')}`, // ส่ง Token จาก localStorage
                },
              });

              const range = quill!.getSelection(true)
              const currentContent = quill!.root.innerHTML;
              const cleanContent = currentContent.replace(/<img[^>]*base64[^>]*>/g, '');
              quill!.root.innerHTML = cleanContent;
              quill!.insertEmbed(range.index, 'image', res.url)
              quill!.setSelection(range.index + 1)
            } catch (e) {
              console.error('Image upload failed', e);
            }
          }
        }
      });

      // Drag & Drop Image Upload
      const toolbar = quill.getModule('toolbar')
      if (toolbar) {
        toolbar.addHandler('image', () => {
          const input = document.createElement('input')
          input.setAttribute('type', 'file')
          input.setAttribute('accept', 'image/*')
          input.click()
          input.onchange = async () => {
            const file = input.files?.[0]
            if (!file) return
            const formData = new FormData()
            formData.append('image', file)
    
            try {
              // อัปโหลดไปยัง API ของคุณ
              const { apiUpload } = useCallApi()
              const res = await apiUpload('/upload', { 
                method: 'POST',
                body: formData,
                headers: {
                  'Authorization': `Bearer ${localStorage.getItem('token')}`,  // ส่ง Token จาก localStorage
                },
              })
    
              const range = quill!.getSelection(true)
              quill!.insertEmbed(range.index, 'image', res.url)
            } catch (e) {
              console.error('Image upload failed', e)
            }
          }
        })
      }
    }
  })
  
  // ถ้า modelValue เปลี่ยนจากภายนอก (เช่น reset form)
  watch(() => props.modelValue, (val) => {
    if (quill && val !== quill.root.innerHTML) {
      quill.root.innerHTML = val
    }
  })
  watch(() => props.disabled, (val) => {
    if (quill) {
      quill.enable(!val)  // true = เปิดให้แก้, false = ปิด
    }
  })
  </script>
  
  <style scoped>
  .quill-editor {
    min-height: 300px;
  }
  </style>
  