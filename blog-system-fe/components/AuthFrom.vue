<template>
    <div class="flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl space-y-6">
            <h1 class="text-2xl font-semibold text-gray-700 text-center">Login</h1>

            <form @submit.prevent="onSubmit" class="space-y-4">
                <div>
                    <label class="block mb-1 text-gray-600">Email</label>
                    <input v-model="userForm.email" type="email"
                        class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="you@example.com" required />
                </div>

                <div>
                    <label class="block mb-1 text-gray-600">Password</label>
                    <input v-model="userForm.password" type="password"
                        class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="••••••••" required />
                </div>

                <div v-if="error" class="text-red-500 text-sm">{{ error }}</div>

                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-xl hover:bg-blue-600 transition"
                    :disabled="loading">
                    <span v-if="loading">Logging in...</span>
                    <span v-else>Login</span>
                </button>
            </form>

            <div class="text-center text-sm text-gray-600">
              do not have account? <span @click="setTypeForm('register')" class="text-blue-500 cursor-pointer hover:underline ml-1">register</span>
            </div>
        </div>
        <RegisterForm v-if="typeForm == 'register'"/>
    </div>
</template>

<script setup>
import RegisterForm from './RegisterForm.vue'


  const userForm = reactive({
      email: null,
      password: null
  })

  const error = ref('')
  const loading = ref(false)

  const { login, user, fetchUser } = useAuth()
  const { setMenu, setTypeForm } = useMenu()

  const onSubmit = async () => {
    error.value = ''
    loading.value = true

    try {
      await login(userForm)
      await fetchUser()
      await setMenu(user.value)
      const routeRedirect = user.value.role == 'admin' ? '/admin' : '/blogs'
      await navigateTo(routeRedirect)
    } catch (err) {
      console.log(err)
      error.value = 'Invalid email or password'
    } finally {
      loading.value = false
    }
  }

</script>