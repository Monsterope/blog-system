export default function useCallApi(){

    const headersParams = {
        "Content-Type": "application/json",
        "Accept": "application/json",
    }

    if (localStorage.getItem("token")){
        headersParams.Authorization = `Bearer ${localStorage.getItem("token")}`
    }
    
    const rtConfig = useRuntimeConfig()
    
    let api = $fetch.create({
        baseURL: rtConfig.public.API_URL,
        headers: headersParams,
        credentials: 'include',
    })

    let apiUpload = $fetch.create({
        baseURL: rtConfig.public.API_URL,
    })

    return {
        api,
        apiUpload
    }
    
}