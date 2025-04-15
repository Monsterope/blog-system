<template>
   <ManageFrom />
</template>
<script setup>
import ManageFrom from '~/components/ManageFrom.vue';

definePageMeta({
    middleware: ["auth-admin"]
})
</script>