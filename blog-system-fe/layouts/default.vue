<template>
    <div class="min-w-screen w-full h-full bg-gray-600 items-center">
        <div class="flex justify-center p-4 mb-4 bg-green-300 fixed top-0 left-0 w-full z-10">
            <UNavigationMenu color="neutral" variant="link" :items="menuItem" class="w-full" />
        </div>
        <div class="flex-1 flex justify-center items-center px-4">
            <div class="min-h-screen w-full md:w-3/4 bg-white text-black p-6 rounded shadow-md pt-24">
                <slot />
            </div>
        </div>
    </div>
</template>
<script setup>
    const rtConfig = useRuntimeConfig()
    const { menuItem } = useMenu()
    useHead({
        title: "Blog System",
        meta: [
            { name:"description" , content: "blog system is have anythink anywhere." },
            { property: 'og:description', content: "blog system is have anythink anywhere." },
            { property: 'og:title', content: "Blog System" },
            { property: 'og:image', content: "/favicon.ico" },
            { property: 'og:url', content: rtConfig.public.APP_URL },
            { property: 'og:type', content: "website" },
            { name: 'twitter:card', content: 'summary_large_image' },
            { name: 'twitter:title', content: "Blog System" },
            { name: 'twitter:description', content: "blog system is have anythink anywhere." },
            { name: 'twitter:image', content: "/favicon.ico" }
        ],
        script: [
            {
            type: 'application/ld+json',
            children: JSON.stringify({
                '@context': 'https://schema.org',
                '@type': 'BlogPosting',
                headline: "Blog System",
                image: ["/favicon.ico"],
                datePublished: "15-04-2025",
                author: {
                    '@type': 'Person',
                    name: 'BlogSystem'
                }
            })
            }
        ]
    })
</script>