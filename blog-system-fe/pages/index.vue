<template>
    <div>
        <BlogForm />
    </div>
</template>

<script setup>
    const { token, user } = useAuth()
    if (token) {
        if (user.value) {
            if (user.value.role == 'admin'){
                navigateTo("/admin")
            }
        }
        navigateTo("/blogs")
    }
</script>