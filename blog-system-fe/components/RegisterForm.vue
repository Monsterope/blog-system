<template>
    <div class="flex items-center justify-center bg-gray-100">
        <div class="w-full bg-white p-8 rounded-2xl shadow-xl space-y-6">
            <button @click="setTypeForm('login')" class="w-full bg-gray-400 text-white py-2 rounded-xl hover:bg-gray-700 transition">
                <span>Back to login</span>
            </button>
            <h1 class="text-2xl font-semibold text-gray-700 text-center">Register</h1>

            <form @submit.prevent="onSubmit" class="space-y-4">
                <div>
                    <label class="block mb-1 text-gray-600">Email</label>
                    <input v-model="form.email" type="email"
                        class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="you@example.com" required />
                </div>

                <div>
                    <label class="block mb-1 text-gray-600">Password</label>
                    <input v-model="form.password" type="password"
                        class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="••••••••" required />
                </div>
<!-- 
                <div>
                    <label class="block mb-1 text-gray-600">Confirm Password</label>
                    <input v-model="form.password_confirmation" type="password"
                        class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="••••••••" required />
                </div> -->

                <div>
                    <label class="block mb-1 text-gray-600">Name</label>
                    <input v-model="form.name" type="text"
                        class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="John Doe" required />
                </div>

                <div v-if="error" class="text-red-500 text-sm">{{ error }}</div>

                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-xl hover:bg-blue-600 transition"
                    :disabled="loading">
                    <span v-if="loading">Registering...</span>
                    <span v-else>Register</span>
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
const form = reactive({
    email: '',
    password: '',
    name: '',
    // password_confirmation: ''
})

const error = ref('')
const loading = ref(false)

const { api } = useCallApi()
const { setTypeForm } = useMenu()

const onSubmit = async () => {
    error.value = ''
    loading.value = true

    try {
        await api("/register", {
            method: "POST",
            body: form
        }) // ต้องมี API register ใน backend
        await setTypeForm('login')
        // await login({ email: form.email, password: form.password })
        // await fetchUser()
        // await setMenu(user.value)
        // const routeRedirect = user.value.role == 'admin' ? '/admin' : '/blogs'
    } catch (err) {
        console.log(err)
        error.value = 'Registration failed. Please check your inputs.'
    } finally {
        loading.value = false
    }
}
</script>