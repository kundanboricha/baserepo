<script setup>
import { ref } from 'vue';
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import Pagination from "@/Components/Miscs/Pagination.vue";
import Toast from "@/Components/Miscs/Toast.vue";
import SortableColumn from "@/Components/Miscs/SortableColumn.vue";

import Multiselect from "@vueform/multiselect";
import { useSelectOptions } from '@/Compasable/selectOptions';
import { useGeneral } from '@/Compasable/General';

const { roleOptions, statusOptions } = useSelectOptions();
const { confirmDelete } = useGeneral();

const props = defineProps(['statistics', 'users', "searchedData", "errors"]);
const page = usePage();
const flash = ref(page.props.flash);

const queryData = new URLSearchParams(window.location.search);

const filterForm = useForm({
    name: props.searchedData.name || null,
    email: props.searchedData.email || null,
    role: props.searchedData.role || null,
    status: queryData.has("status") ? queryData.get("status") : null,
    orderBy: queryData.has("orderBy") ? queryData.get("orderBy") : "id",
    sortAs: queryData.has("sortAs") ? queryData.get("sortAs") : "asc",
    page: queryData.has("page") ? queryData.get("page") : 1,
    per_page: queryData.has("per_page") ? queryData.get("per_page") : 10,
});

const filter = () => {
    filterForm.get(route("users.index"), {
        preserveState: true,
    });
};

const changePage = (link) => {
    const url = new URL(link);
    const searchParams = url.searchParams;
    filterForm.page = searchParams.get("page");
    filterForm.status = null;
    filter();
};

const calculateIndex = (currentIndex) => {
    return ((filterForm.page - 1) * filterForm.per_page) + currentIndex + 1;
};
</script>

<script>
import AuthLayout from "@/Layouts/AuthenticatedLayout.vue";
export default {
    layout: AuthLayout,
};
</script>

<template>
    <Head title="Users List" />

    <h4 class="py-3 mb-2">
        <span class="text-muted fw-light">Users / </span> Users Listing
    </h4>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-1">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1">Users Listing</h4>
            <p class="text-muted">Browse and manage Users accounts</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
                <div class="row gy-4 gy-sm-1">
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                            <div>
                                <h3 class="mb-1">{{ statistics['totalUsers'] }}</h3>
                                <p class="mb-0">Total User</p>
                            </div>
                            <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-secondary rounded"><i
                                        class="ti ti-user ti-sm"></i></span>
                            </span>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none me-4" />
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                            <div>
                                <h3 class="mb-1">{{ statistics['activeUsers'] }}</h3>
                                <p class="mb-0">Active User</p>
                            </div>
                            <span class="avatar me-lg-4">
                                <span class="avatar-initial bg-label-secondary rounded"><i
                                        class="ti ti-user-plus ti-sm"></i></span>
                            </span>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none" />
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                            <div>
                                <h3 class="mb-1">{{ statistics['defaultImageUsers'] }}</h3>
                                <p class="mb-0">Users With Default Image</p>
                            </div>
                            <span class="avatar me-sm-4">
                                <span class="avatar-initial bg-label-secondary rounded"><i
                                        class="ti ti-user-check ti-sm"></i></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h3 class="mb-1">{{ statistics['inActiveUsers'] }}</h3>
                                <p class="mb-0">InActive User</p>
                            </div>
                            <span class="avatar">
                                <span class="avatar-initial bg-label-secondary rounded">
                                    <i class="ti ti-user-exclamation ti-sm"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="accordion">
            <h2 class="accordion-header" id="headingOne">
                <button type="button" class="accordion-button fs-3 d-flex align-items-center" data-bs-toggle="collapse"
                    data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">
                    <h5 class="card-title m-0">Search Filter</h5>
                </button>
            </h2>
            <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body border-top p-4">
                    <form @submit.prevent="filter">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Name" class="form-label">
                                        Name:
                                    </label>
                                    <input type="text" class="form-control" v-model="filterForm.name" placeholder="Name"
                                        max="100" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Email" class="form-label">
                                        Email:
                                    </label>
                                    <input type="text" class="form-control" v-model="filterForm.email" placeholder="Email"
                                        max="100" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Email" class="form-label">
                                        Status:
                                    </label>
                                    <Multiselect v-model="filterForm.status" :searchable="true" :options="statusOptions"
                                        mode="single" :close-on-select="true" placeholder="Select User Status" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Role" class="form-label">
                                        Role:
                                    </label>
                                    <Multiselect v-model="filterForm.role" :searchable="true" :options="roleOptions"
                                        mode="single" :close-on-select="true" placeholder="Select Role " />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary me-1">
                                    Search
                                </button>
                                <Link :href="route('users.index')" class="btn btn-outline-secondary waves-effect">
                                Discard
                                </Link>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-bottom p-2">
            <div class="d-flex justify-content-between align-content-center p-1">
                <div class="row">
                    <div class="col-md-12">
                        <select class="form-select" v-model="filterForm.per_page" @change="filter">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <Link class="btn btn-primary" :href="route('users.create')">
                        <i class="menu-icon text-white tf-icons ti ti-plus"></i> Add User
                        </Link>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">
                                <SortableColumn label="#ID" :form="filterForm" :formSubmit="filter" orderBy="id" />
                            </th>
                            <th scope="col">
                                <SortableColumn label="Name" :form="filterForm" :formSubmit="filter" orderBy="name" />
                            </th>
                            <th scope="col">
                                <SortableColumn label="Email" :form="filterForm" :formSubmit="filter" orderBy="email" />
                            </th>
                            <th scope="col">Role</th>
                            <th scope="col">Status</th>
                            <th scope="col">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-if="users.data.length <= 0">
                            <td align="center" colspan="6"> No data available</td>
                        </tr>
                        <tr v-else v-for="(user, index) in users.data" :key="index">
                            <th scope="row">{{ calculateIndex(index) }}</th>
                            <td>
                                <Link :href="route('users.edit', user.ulid)">
                                {{ user.name }}
                                </Link>
                            </td>
                            <td>{{ user.email }}</td>
                            <td>{{ (user.role == 1) ? "Admin" : "User" }}</td>
                            <td>{{ user.status === 1 ? "Active" : "InActive" }}</td>
                            <td>
                                <Link :href="route('users.edit', user.ulid)">
                                <i class="menu-icon text-info tf-icons ti ti-edit"></i>
                                </Link>
                                <span @click="confirmDelete(route('users.delete', user.ulid))" class="cursor-pointer">
                                    <i class="menu-icon text-danger tf-icons ti ti-trash"></i>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <Pagination :links="users.links" :changePageFunction="changePage" class="float-end me-4" />
            </div>
        </div>
    </div>
    <!-- END Table -->
    <Toast v-if="flash.status" />
</template>
