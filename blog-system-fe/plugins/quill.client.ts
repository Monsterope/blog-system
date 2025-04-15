import { defineNuxtPlugin } from '#app'
import Quill from 'quill'

// ตัวอย่าง custom theme หรือ module ถ้าใช้ (ตอนนี้ใช้ default)
export default defineNuxtPlugin(() => {
  return {
    provide: {
      quill: Quill
    }
  }
})
