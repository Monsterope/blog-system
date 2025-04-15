export default defineNuxtRouteMiddleware(async () => {

    const { token, user, fetchUser } = useAuth()
    const { setMenu } = useMenu()

    if (!token) return navigateTo('/login')

    if (!user.value) {
        await fetchUser()
        if (!user.value) return navigateTo('/login')
        await setMenu(user.value)
    }

  })
  