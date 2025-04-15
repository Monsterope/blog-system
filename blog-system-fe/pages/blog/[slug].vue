<template>
    <!-- <MetaTags :title="tagTitle"/> -->
    <DetailForm :blog-id="blogId" />
</template>

<script setup>
definePageMeta({
    middleware: ['auth']
})
const route = useRoute()
const blogId = ref(route.params.slug)
</script>