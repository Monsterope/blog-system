// plugins/tiptap/ImageDrop.ts
import { Extension } from '@tiptap/core'
import { Plugin } from 'prosemirror-state'

const { api } = useCallApi()

export const ImageDrop = Extension.create({
  name: 'imageDrop',

  addProseMirrorPlugins() {
    return [
      new Plugin({
        props: {
          handleDOMEvents: {
            drop: (view, event) => {
              const hasFiles = event.dataTransfer?.files?.length
              if (!hasFiles) return false

              const images = Array.from(event.dataTransfer.files).filter(file =>
                /image/i.test(file.type)
              )

              if (images.length === 0) return false

              event.preventDefault()

              images.forEach(async (image) => {
                const formData = new FormData()
                formData.append('image', image)

                try {
                  const res = await api('/upload', {
                    method: 'POST',
                    body: formData,
                  })
                //   const data = await res.json()

                  const node = this.editor.schema.nodes.image.create({
                    src: res.url,
                  })

                  // Replace the selection with the image node
                  const transaction = view.state.tr.replaceSelectionWith(node)
                  view.dispatch(transaction)
                } catch (err) {
                  console.error('Image upload failed', err)
                }
              })

              return true
            },
          },
        },
      }),
    ]
  },
})
