<script setup>
import { onMounted, ref, watch } from 'vue'
const props = defineProps(['label', 'id', 'permissionConditions', 'classConditions'])
const isOpen = ref(false);
const Menu = ref(null);
watch(isOpen, (newData) => {
    console.log(newData);
    if (newData === true) {
        Menu.value.classList.add('open');
    }
});

const toggleDropdown = (id, e) => {
    Menu.value = document.getElementById(id);
    if (!e.target.classList.contains('dropdown-link')) {
        isOpen.value = !isOpen.value;
        if (Menu.value.classList.contains('open')) {
            Menu.value.classList.remove('open');
        } else {
            Menu.value.classList.add('open');
        }
    }
}
</script>

<template>
    <li v-if="permissionConditions" class="menu-item dd-item" @click="toggleDropdown(id, $event)" :id="id"
        :class="(classConditions) ? 'active' : ''">
        <a class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-settings"></i>
            <div>{{ label }}</div>
        </a>
        <ul class="menu-sub">
            <slot></slot> <!-- Add stop and prevent modifiers to prevent default link behavior -->
        </ul>
    </li>
</template>

<style>
.bg-menu-theme .menu-inner .menu-item.dd-item.active>.menu-link.menu-toggle {
    background: linear-gradient(72.47deg, #7367f0 22.16%, rgba(115, 103, 240, 0.7) 76.47%);
    box-shadow: none !important;
    color: #fff !important;
}

.bg-menu-theme .menu-inner .menu-item.dd-item.active>.menu-sub .menu-item.dropdown-link.active .menu-link:not(.menu-toggle) {
    background: #f4f4f5 !important;
    box-shadow: none !important;
    color: #000 !important;
}
</style>