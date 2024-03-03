<script setup>
import { Link, router } from '@inertiajs/vue3';
import { computed, onMounted, reactive, ref } from 'vue';
import Dropdown from '@/Components/Miscs/Dropdown.vue';
import { useGeneral } from '@/Compasable/General';
const { asset } = useGeneral();
const HTML = document.querySelector("html");
let sideFlag = false;


onMounted(() => {
    router.on('finish', (event) => {
        SideLinks.currentActive = window.location.pathname.split('/');
    });
});


const sideCollapse = () => {
    if (sideFlag === true) {
        HTML.className = "light-style layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed";
    }
}

const sideExpand = () => {
    HTML.className = "light-style layout-navbar-fixed layout-menu-fixed layout-compact";
}

const allowSideChange = (id) => {

    const Icon = document.getElementById(id);
    if (sideFlag == true) {
        sideFlag = false;
        Icon.classList.add("text-primary");
    } else {
        sideFlag = true;
        Icon.classList.remove("text-primary");
        sideCollapse();
    }
}


const SideLinks = reactive({
    currentActive: window.location.pathname.split('/')
});


const dropdownConditions = reactive({
    rolePermissions: computed(() => {
        return checkPermission('roles.index') || checkPermission('permissions.index') || checkPermission('permission-groups.index');
    })
});

const dropdownClassConditions = reactive({
    rolePermissions: computed(() => {
        return SideLinks.currentActive[1] === 'roles' || SideLinks.currentActive[1] === 'permissions' || SideLinks.currentActive[1] === 'permission-groups';
    })
})

</script>
<template>
    <!-- Menu -->
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" @mouseenter="sideExpand"
        @mouseleave="sideCollapse">

        <div class="app-brand demo">
            <Link :href="route('index')" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                        fill="#7367f0" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                        d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                        fill="#7367f0" />
                </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bold">Template</span>
            </Link>

            <a class="layout-menu-toggle text-large ms-auto">
                <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle text-primary" id="allowIcon"
                    @click="allowSideChange('allowIcon')"></i>
                <i class="ti ti-x d-block d-xl-none ti-sm align-middle" @click="sideCollapse()"></i>
            </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">

            <!-- Dashboards -->
            <li class="menu-item" :class="SideLinks.currentActive[1] === 'dashboard' ? 'active' : ''">
                <Link :href="route('dashboard')" class="menu-link">
                <i class="menu-icon tf-icons ti ti-home"></i>
                <div data-i18n="Dashboard">Dashboard</div>
                </Link>
            </li>


            <!-- Users -->
            <li class="menu-item" :class="SideLinks.currentActive[1] === 'users' ? 'active' : ''">
                <Link :href="route('users.index')" class="menu-link">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Users">Users</div>
                </Link>
            </li>

            <!-- Roles & Permission Manager -->

            <!-- <Dropdown label="Roles & Permissions" :permissionConditions="dropdownConditions.rolePermissions"
                :classConditions="dropdownClassConditions.rolePermissions" id="rolePermission">

                <li v-if="checkPermission('roles.index')" class="menu-item dropdown-link"
                    :class="SideLinks.currentActive[1] === 'roles' ? 'active' : ''">
                    <Link :href="route('roles.index')" class="menu-link dropdown-link ">
                    Roles
                    </Link>
                </li>


                <li v-if="checkPermission('permissions.index')" class="menu-item dropdown-link"
                    :class="SideLinks.currentActive[1] === 'permissions' ? 'active' : ''">
                    <Link :href="route('permissions.index')" class="menu-link dropdown-link ">
                    Permission
                    </Link>
                </li>

                <li v-if="checkPermission('permission-groups.index')" class="menu-item dropdown-link"
                    :class="SideLinks.currentActive[1] === 'permission-groups' ? 'active' : ''">
                    <Link :href="route('permission-groups.index')" class="menu-link dropdown-link ">
                    Permission Groups
                    </Link>
                </li>

            </Dropdown> -->


        </ul>
    </aside>
    <!-- / Menu -->
</template>
