<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useGeneral } from '@/Compasable/General';

const { asset } = useGeneral();
const props = defineProps([
    'user',
    'errors',
]);

const form = useForm({
    password: '',
    confirmPassword: '',
    email: props.user.email,
});

const reveal = (field) => {
    const input = document.getElementById(field);
    if (input.type == "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}
const submit = () => {
    form.post(route('set.password'), {
        onFinish: () => form.reset(),
    });
};
</script>

<script>
import GuestLayout from '@/Layouts/GuestLayout.vue';

export default {
    layout: GuestLayout,
}

</script>

<template>
    <Head title="Set Password" />

    <!-- /Left Text -->
    <div class="d-none d-lg-flex col-lg-7 p-0">
        <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
            <img :src="asset('assets/img/illustrations/auth-reset-password-illustration-light.png')"
                alt="auth-reset-password-cover" class="img-fluid my-5 auth-illustration"
                data-app-light-img="illustrations/auth-reset-password-illustration-light.png"
                data-app-dark-img="illustrations/auth-reset-password-illustration-dark.png" />

            <img :src="asset('assets/img/illustrations/bg-shape-image-light.png')" alt="auth-reset-password-cover"
                class="platform-bg" data-app-light-img="illustrations/bg-shape-image-light.png"
                data-app-dark-img="illustrations/bg-shape-image-dark.png" />
        </div>
    </div>
    <!-- /Left Text -->

    <div class="d-flex col-12 col-lg-5 align-items-center p-4 p-sm-5">
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

            <h4 class="mb-1">Set Password 🔒</h4>
            <form @submit.prevent="submit">
                <div class="mb-3 form-password-toggle">
                    <label class="form-label" for="password">
                        New Password <span class="text-danger">*</span>
                        : </label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control" v-model="form.password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password" maxlength="50" />
                        <span class="input-group-text cursor-pointer" @click="reveal('password')">
                            <i class="ti ti-eye-off"></i>
                        </span>
                    </div>
                    <span v-if="errors.password" class="text-danger">{{ errors.password }}</span>
                </div>
                <div class="mb-3 form-password-toggle">
                    <label class="form-label" for="confirm-password">
                        Confirm Password <span class="text-danger">*</span>
                        : </label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="confirm-password" class="form-control" v-model="form.confirmPassword"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password" maxlength="50" />
                        <span class="input-group-text cursor-pointer" @click="reveal('confirm-password')">
                            <i class="ti ti-eye-off"></i>
                        </span>
                    </div>
                    <span v-if="errors.confirmPassword" class="text-danger">{{ errors.confirmPassword }}</span>
                </div>
                <button class="btn btn-primary d-grid w-100 mb-3">Set new password</button>
                <div class="text-center">
                    <Link :href="route('login')">
                    <i class="ti ti-chevron-left scaleX-n1-rtl"></i>
                    Back to login
                    </Link>
                </div>
            </form>
        </div>
    </div>
</template>
