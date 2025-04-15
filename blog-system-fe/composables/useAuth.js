export default function useAuth() {
    const token = localStorage.getItem("token")
    const user = useState('auth-user', () => null)
    
    const { api } = useCallApi()

    async function login(loginForm) {
        try {
            const data = await api("login", {
                method: "POST",
                body: loginForm
            })
            localStorage.setItem("token", data.access_token)
        } catch (e) {
            console.log("sss", e)
            token = null
        }
    }
    
    async function fetchUser() {
        const tokenCur = !token ? localStorage.getItem("token") : token
        try {
            const data = await api("/user", {
                headers: {
                    "Authorization": `Bearer ${tokenCur}` 
                }
            })
            user.value = data
        } catch (e) {
            user.value = null
            console.log("error")
        }
    }

    async function logout() {
        const tokenCur = !token ? localStorage.getItem("token") : token
        try {
            await api("/logout", {
                method: "POST",
                headers: {
                    "Authorization": `Bearer ${tokenCur}` 
                }
            })
            localStorage.removeItem("token")
            user.value = null
        } catch (e) {
            user.value = null
            console.log(e)
        }
    }

    return {
        token,
        user,
        login,
        logout,
        fetchUser,
      }
    
}