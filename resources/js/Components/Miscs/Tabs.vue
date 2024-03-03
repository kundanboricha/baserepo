<script setup>
import { ref } from "vue";

const props = defineProps({
    tabs: Object,
    changeTab: Function,
});
const defaultTab = props.tabs[0].default;
const currentTab = ref(defaultTab);

const changeTab = (tabName) => {
    currentTab.value = tabName;
    props.changeTab(tabName)
}
</script>
<template>
    <ul class="nav nav-pills flex-column flex-md-row mb-4" v-if="tabs.length > 0">
        <li class="nav-item cursor-pointer" v-for="(tab, index) in tabs" :key="index">
            <template v-if="index != 0">
                <button @click="changeTab(tab.name)" class="nav-link" :class="currentTab == tab.name ? 'active' : ''">
                    <font-awesome-icon class="ti ti-xs me-1" :icon="['far', tab.icon]" />
                    {{ tab.label }}
                </button>
            </template>
        </li>
    </ul>
</template>