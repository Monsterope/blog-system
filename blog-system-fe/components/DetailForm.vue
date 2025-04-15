<template>
    <div>
        <div v-if="!blog" class="flex items-center gap-4">
            <USkeleton class="h-12 w-12 rounded-full" />

            <div class="grid gap-2">
            <USkeleton class="h-4 w-[250px]" />
            <USkeleton class="h-4 w-[200px]" />
            </div>
        </div>
        <UProgress v-if="!blog" size="xl" />
        <div v-if="blog">
            <h1 class="text-2xl md:text-4xl font-extrabold">{{ blog.title }}</h1>
            <div v-html="blog.contents" class="mt-2"></div>
        </div>
    </div>
</template>
<script setup>
const props = defineProps({
    blogId: {
        type: String,
        default: null,
    }
})

const { api } = useCallApi()
const blog = ref(null)
const { setTagTitle } = useTag()
const rtConfig = useRuntimeConfig()

onMounted(async () => {
    const resp = await api(`/blogs/${props.blogId}`)
    const contentDatas = await resp.data.contents.replace(/<img /g, '<img loading="lazy" ')
    setTagTitle(resp.data.title)
    blog.value = {
        title: resp.data.title,
        contents: contentDatas
    }
    useHead({
        title: resp.data.meta_title,
        meta: [
            { name:"description" , content: resp.data.meta_description },
            { property: 'og:description', content: resp.data.meta_description },
            { property: 'og:title', content: resp.data.meta_title },
            { property: 'og:image', content: "/favicon.ico" },
            { property: 'og:url', content:  rtConfig.public.APP_URL },
            { property: 'og:type', content: "website" },
            { name: 'twitter:card', content: 'summary_large_image' },
            { name: 'twitter:title', content: resp.data.meta_title },
            { name: 'twitter:description', content: resp.data.meta_description },
            { name: 'twitter:image', content: "/favicon.ico" }
        ],
        script: [
            {
            type: 'application/ld+json',
            children: JSON.stringify({
                '@context': 'https://schema.org',
                '@type': 'BlogPosting',
                headline: resp.data.meta_title,
                image: ["/favicon.ico"],
                datePublished: resp.data.created_at,
                author: {
                    '@type': 'Person',
                    name: 'BlogSystem'
                }
            })
            }
        ]
    })
})
</script>