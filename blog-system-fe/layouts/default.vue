<template>
    <div class="min-w-screen w-full h-full bg-gray-600 items-center">
        <div class="flex justify-center p-4 mb-4 bg-green-300 fixed top-0 left-0 w-full z-10">
            <UNavigationMenu color="neutral" variant="link" :items="menuItem" class="w-full" />
        </div>
        <div class="flex-1 flex justify-center items-center px-4">
            <div class="min-h-screen w-full md:w-3/4 bg-white text-black p-6 rounded shadow-md pt-24">
                <slot />
            </div>
        </div>
    </div>
</template>
<script setup>
    const { menuItem } = useMenu()
</script>