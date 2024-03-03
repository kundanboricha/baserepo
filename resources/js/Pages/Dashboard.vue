<script setup>
import { ref } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import Toast from "@/Components/Miscs/Toast.vue";
import { useGeneral } from '@/Compasable/General';
const { asset } = useGeneral();
const page = usePage();
const flash = ref(page.props.flash);
const user = page.props.auth.user;
</script>
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
export default {
    layout: AuthenticatedLayout,
}
</script>

<template>
    <Head title="Dashboard" />
    <h3>Welcome back, {{ user.name }} 👋🏻</h3>
    <Toast v-if="flash.status" />
</template>
