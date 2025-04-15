<template>
    <div>
        <div v-if="isLoading" class="flex items-center gap-4">
            <USkeleton class="h-12 w-12 rounded-full" />

            <div class="grid gap-2">
                <USkeleton class="h-4 w-[250px]" />
                <USkeleton class="h-4 w-[200px]" />
            </div>
        </div>
        <UProgress v-if="isLoading" size="xl" />
        <UTable v-if="!isLoading" :columns="columns" :data="blogList" />
    </div>
</template>
<script setup>
    const columns = [
        {
            id: 'id',
            accessorKey: 'id',
            header: () => h('div', { class: 'text-red-500 font-bold' }, 'ID'),
        },
        {
            id: 'title',
            accessorKey: 'title',
            header: () => h('div', { class: 'text-blue-800 font-bold' }, 'Title'),
            cell: ({row}) => {
                const formatted = new Date(row.original.created_at).toISOString().slice(0, 19).replace("T", " ")
                return h('div', { class: 'cursor-pointer hover:underline hover:underline-offset-1' }, [
                    h('p', { class: 'text-2xl', onClick: () => clickDetail(row.original.id) }, `${row.original.title}`),
                    h('p', { class: 'text-xs' }, `@${formatted}`)
                ])
            }
        },
    ]

    const clickDetail = (id) => {
        return navigateTo(`/blog/${id}`)
    }
    const blogList = ref([])
    // const {api} = useAxios()
    const {api} = useCallApi()
    const isLoading = ref(false)


    onMounted(async () => {
        isLoading.value = true
        const { data:res } = await useAsyncData("blogs", () => api("blogs"))
        blogList.value = res.value.data
        isLoading.value = false
        // console.log(blogList.value)
    })

</script>