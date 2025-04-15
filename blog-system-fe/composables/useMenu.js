export default function useMenu() {
    const menuItem = useState("menu", () => [
        [
            {
                label: 'Blog',
                icon: 'i-lucide-book-open',
                to: '/'
            },
        ],
        [
            {
                label: "Sign in",
                icon: 'i-line-md:account',
                to: '/login'
            },
        ],
    ])

    async function setMenu(userData) {

        const routeHome = userData.role == "admin" ? '/admin' : "/blogs"
        
        menuItem.value = [
            [
                {
                    label: 'Blog',
                    icon: 'i-lucide-book-open',
                    to: routeHome
                },
            ],
            [
                {
                    label: userData.name,
                    icon: 'i-line-md:account'
                },
                {
                    icon: 'i-simple-line-icons:power',
                    to: '/logout'
                },
            ],
        ]

    }

    async function setDefaultMenu() {
        menuItem.value = [
            [
                {
                    label: 'Blog',
                    icon: 'i-lucide-book-open',
                    to: '/'
                },
            ],
            [
                {
                    label: "Sign in",
                    icon: 'i-line-md:account',
                    to: '/login'
                },
            ],
        ]
    }

    const typeForm = useState("type-form", () => "login")

    async function setTypeForm(param) {
        typeForm.value = param
    }

    return {
        menuItem,
        setMenu,
        setDefaultMenu,
        typeForm,
        setTypeForm,
    }
}