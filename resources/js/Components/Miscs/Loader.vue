<script setup>
import { onMounted } from 'vue'
import { useLoading } from 'vue-loading-overlay'

onMounted(() => {
    const $loading = useLoading({
        loader: 'bars',
        width: 130,
        height: 50,
        color: "#7367f0"
    });
    const loader = $loading.show();
    setTimeout(() => {
        loader.hide()
    }, 900)
});
</script>
<template></template>
