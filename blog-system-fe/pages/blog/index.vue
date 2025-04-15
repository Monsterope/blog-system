<template>
    <div></div>
</template>

<script setup>
definePageMeta({
    middleware: ['auth']
})
const { user } = useAuth()
if (user.value) {
    if (user.value.role == 'admin'){
        navigateTo("/admin")
    }
}
navigateTo("/blogs")

</script>