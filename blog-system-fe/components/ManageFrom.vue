<template>
    <div>
        <div v-if="isLoading" class="flex items-center gap-4">
            <USkeleton class="h-12 w-12 rounded-full" />

            <div class="grid gap-2">
                <USkeleton class="h-4 w-[250px]" />
                <USkeleton class="h-4 w-[200px]" />
            </div>
        </div>
        <div v-if="!isLoading" class="flex justify-end mb-4">
            <UButton color="secondary" icon="i-mi:circle-add" @click="clickModal('cre', null)">Add blog</UButton>
        </div>
        <div v-if="!isLoading">
            <UTable :columns="columns" :data="blogList" />
        </div>
        <UModal v-model:open="modalAction" :title="modalName" class="!w-[75vw] !max-w-[75vw]" :ui="{
            body: 'p-6 space-y-4'
        }">
            <template #body>
                <UProgress v-if="isLoading == true" size="xl" />
                <div v-if="isLoading == false" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-white mb-1">Title</label>
                        <UInput :disabled="modalName == 'Blog'" v-model="form.title" placeholder="Enter article title..." size="lg" />
                    </div>
                    <div class="flex">
                        <div class="mr-1">
                            <label class="block text-sm font-semibold">Meta Title</label>
                            <UInput v-model="form.meta_title" placeholder="For SEO" />
                        </div>
                        <div class="ml-1">
                            <label class="block text-sm font-semibold">Meta Description</label>
                            <UInput v-model="form.meta_description" placeholder="Short description for search engines" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white mb-1">Content</label>
                        <div class="border border-gray-300 rounded-md overflow-hidden">
                            <QuillEditor :disabled="modalName == 'Blog'" v-model="form.contents" />
                        </div>
                    </div>
                    <!-- <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div>
                            <label class="font-semibold">Meta Title</label>
                            <UInput v-model="form.meta_title" placeholder="For SEO" />
                        </div>
                        <div>
                            <label class="font-semibold">Meta Description</label>
                            <UInput v-model="form.meta_description" placeholder="Short description for search engines" />
                        </div>
                    </div> -->
                    <div class="flex justify-end space-x-2 pt-4 border-t mt-6">
                        <UButton v-if="modalName != 'Blog'" :color="actionType == 'upd' ? 'warning' : 'primary'" @click="handleSubmit">Save</UButton>
                        <UButton color="gray" variant="ghost" @click="modalAction = false">Cancel</UButton>
                    </div>
                </div>
            </template>
        </UModal>

        <UModal v-model:open="isConfirmDeleteOpen" prevent-close>
            <template #header>
                <div class="flex items-center space-x-2 text-red-600">
                    <UIcon name="i-heroicons-exclamation-triangle" class="w-6 h-6" />
                <span class="font-bold text-lg">Confirm delete</span>
                </div>
            </template>

            <template #body>
                <p class="text-gray-200">Are you sure delete blog?</p>
            </template>

            <template #footer>
                <div class="flex justify-end space-x-2">
                    <UButton color="red" @click="confirmDelete">Confirm</UButton>
                <UButton color="gray" variant="ghost" @click="isConfirmDeleteOpen = false">No</UButton>
                </div>
            </template>
        </UModal>
    </div>
</template>

<script setup>
    import { UButton } from '#components'
    import QuillEditor from '@/components/QuillEditor.vue'

    const toast = useToast()
    const { api } = useCallApi()

    const isLoading = ref(false)
    const blogList = ref([])
    const callBlogList = async () => {
        isLoading.value = true
        const { data:res } = await useAsyncData("blogs", () => api("blogs"))
        blogList.value = res.value.data
        isLoading.value = false
    }

    const blogId = ref(null)
    const form = reactive({
        title: '',
        contents: '',
        meta_title: '',
        meta_description: ''

    })
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
                    h('p', { class: 'text-2xl', onClick: () => clickModal('rea', row.original.id) }, `${row.original.title}`),
                    h('p', { class: 'text-xs' }, `@${formatted}`)
                ])
            }
        },
        {
            id: 'action',
            header: () => h('div', { class: 'text-blue-800 font-bold' }, ''),
            cell: ({row}) => {
                return h('div', { class: '' }, [
                    h(UButton, {
                        icon: 'i-mi:pen',
                        color: 'warning',
                        class: 'mx-1',
                        onClick: () => clickModal('upd', row.original.id)
                    }),
                    h(UButton, {
                        icon: 'i-mi:delete',
                        color: 'error',
                        class: 'mx-1',
                        onClick: () => openDeleteModal(row.original.id)
                    }),
                ])
            }
        },
    ]

    const modalAction = ref(false)
    const modalName = ref("Blog")
    const actionType = ref('rea')
    const clickModal = async (typeAction, id = null) => {
        // alert(`${typeAction}: ${id}`)
        isLoading.value = true
        modalAction.value = true
        actionType.value = typeAction
        if (typeAction == 'cre') {
            blogId.value = null
            form.title = ''
            form.contents = ''
            form.meta_title = ''
            form.meta_description = ''
            modalName.value = "Blog create"
            isLoading.value = false
        }
        if (typeAction == 'upd') {
            const resp = await api(`/blogs/${id}`)
            blogId.value = id
            form.title = resp.data.title
            form.contents = resp.data.contents
            form.meta_title = resp.data.meta_title
            form.meta_description = resp.data.meta_description
            modalName.value = "Blog update"
            isLoading.value = false
        }
        if (typeAction == 'rea') {
            const resp = await api(`/blogs/${id}`)
            blogId.value = id
            form.title = resp.data.title
            form.contents = resp.data.contents
            form.meta_title = resp.data.meta_title
            form.meta_description = resp.data.meta_description
            modalName.value = "Blog"
            isLoading.value = false
        }
    }
    const handleSubmit = async () => {
        const methodCall = blogId.value == null ? "POST" : "PUT"
        const routeCall = blogId.value != null ? `/blogs/${blogId.value}` : "/blogs"
        const descToast = actionType.value == 'cre' ? "Created blog success." : "Updated blog success."
        isLoading.value = true
        try {
            await api(routeCall, {
                method: methodCall,
                body: form,
            })
            toast.add({
                title: "SUCCESS",
                description: descToast,
                color: "success"
            })
            await callBlogList()
            isLoading.value = false
            modalAction.value = false
        } catch (error) {
            toast.add({
                title: "ERROR",
                description: "Process error please try again.",
                color: "error"
            })
            isLoading.value = false
        }
        console.log("call", form.contents)
    }

    const isConfirmDeleteOpen = ref(false)
    const openDeleteModal = (id) => {
        blogId.value = id
        isConfirmDeleteOpen.value = true
    }
    const confirmDelete = async () => {
        try {
            await api(`/blogs/${blogId.value}`, { method: 'DELETE' })
            toast.add({
                title: "SUCCESS",
                description: "Delete blog success.",
                color: "success"
            })
            await callBlogList()
            isConfirmDeleteOpen.value = false
        } catch (err) {
            toast.add({
                title: "ERROR",
                description: "Process error please try again.",
                color: "error"
            })
        }
    }

    onMounted(async () => {
        await callBlogList()
        // console.log(blogList.value)
    })

</script>