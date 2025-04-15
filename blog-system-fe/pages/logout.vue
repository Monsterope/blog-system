<template>
    <div v-if="isLoading" class="flex items-center gap-4">
        <USkeleton class="h-12 w-12 rounded-full" />

        <div class="grid gap-2">
            <USkeleton class="h-4 w-[250px]" />
            <USkeleton class="h-4 w-[200px]" />
        </div>
    </div>
</template>
<script setup>
    definePageMeta({
        middleware: ['auth']
    })
    const isLoading = ref(false)
    const { logout } = useAuth()
    const { setDefaultMenu } = useMenu()

    onMounted(async () => {
        isLoading.value = true
        await logout()
        await setDefaultMenu()
        isLoading.value = false
        navigateTo("/login")
    })
    

</script>