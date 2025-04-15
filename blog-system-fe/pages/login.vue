<template>
    <AuthFrom v-if="typeForm == 'login'" />
    <RegisterForm v-if="typeForm == 'register'"/>
</template>

<script setup>
const { typeForm } = useMenu()
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