<script setup>
import { ref } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import Toast from '@/Components/Miscs/Toast.vue';
import { useGeneral } from '@/Compasable/General';
const { asset } = useGeneral();

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    errors: [Object, null]
});
const page = usePage();
const flash = ref(page.props.flash);

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('post.login'), {
        onFinish: () => form.reset('password'),
    });
};


const reveal = (field) => {
    const input = document.getElementById(field);
    // alert(input.type);
    if (input.type == "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}

</script>

<script>
import GuestLayout from '@/Layouts/GuestLayout.vue';
export default {
    layout: GuestLayout,
}
</script>

<template>
    <Head title="Login" />

    <!-- /Left Text -->
    <div class="d-none d-lg-flex col-lg-7 p-0">
        <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center"
            style="background-color: #f8f7fa;">
            <img :src="asset('assets/img/illustrations/auth-login-illustration-light.png')" alt="auth-login-cover"
                class="img-fluid my-5 auth-illustration"
                data-app-light-img="illustrations/auth-login-illustration-light.png"
                data-app-dark-img="illustrations/auth-login-illustration-dark.png" />
            <img :src="asset('assets/img/illustrations/bg-shape-image-light.png')" alt="auth-login-cover"
                class="platform-bg" data-app-light-img="illustrations/bg-shape-image-light.png"
                data-app-dark-img="illustrations/bg-shape-image-dark.png" />
        </div>
    </div>
    <!-- /Left Text -->

    <!-- Login -->
    <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
        <div class="w-px-400 mx-auto">
            <!-- Logo -->
            <div class="app-brand mb-4">
                <Link :href="route('index')" class="app-brand-link gap-2">
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
                </Link>
            </div>
            <!-- /Logo -->
            <h3 class="mb-1">Welcome to CodersHut! 👋</h3>
            <p class="mb-4">Please sign-in to your account</p>

            <form id="formAuthentication" class="mb-3" @submit.prevent="submit">
                <div class="mb-3">
                    <label class="form-label" for="Email">
                        Email <span class="text-danger">*</span>
                        : </label>
                    <input class="form-control" type="text" placeholder="john@example.com" aria-describedby="login-email"
                        autofocus="" tabindex="1" v-model="form.email" maxlength="100" />
                    <div class="text-danger" v-if="errors.email">{{ errors.email }}</div>
                </div>
                <div class="mb-3 form-password-toggle">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="password">
                            Password <span class="text-danger">*</span>
                            : </label>
                        <Link :href="route('password.request')">
                        <small>Forgot Password?</small>
                        </Link>
                    </div>
                    <div class="input-group input-group-merge">
                        <input class="form-control form-control-merge" type="password" placeholder="············"
                            aria-describedby="login-password" id="password" tabindex="2" v-model="form.password" />
                        <span class="input-group-text cursor-pointer">
                            <font-awesome-icon :icon="['fad', 'eye']" @click="reveal('password')" />
                        </span>
                    </div>
                    <div class="text-danger" v-if="errors.password">{{ errors.password }}</div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember-me" />
                        <label class="form-check-label" for="remember-me"> Remember Me </label>
                    </div>
                </div>
                <button class="btn btn-primary d-grid w-100">Sign in</button>
            </form>
        </div>
    </div>
    <!-- /Login -->
    <Toast v-if="flash.status" />
</template>
