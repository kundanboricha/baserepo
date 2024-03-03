<script setup>
import { onMounted, reactive, ref } from "vue";
import { useForm, Head, Link, usePage } from "@inertiajs/vue3";

import Toast from "@/Components/Miscs/Toast.vue";
import { Cropper } from "vue-advanced-cropper";
import "vue-advanced-cropper/dist/style.css";

import { useGeneral } from "@/Compasable/General";
const { asset, resolveImageURL } = useGeneral();

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    errors: [Object],
});

const page = usePage();
const flash = ref(page.props.flash);
const user = ref(page.props.auth.user);

const updateProfile = useForm({
    name: user.value.name,
    email: user.value.email,
    password: "",
    confirmPassword: "",
    image: null,
});

const update = () => {
    updateProfile.post(route("profile.update"), {
        onSuccess: (res) => {
            user.value.profile_pic = res.props.auth.user.profile_pic;
            flash.value.status = "true";
            flash.value.message = "Profile updated successfully.";
        },
        onFinish: () => {
            currentImage.cropImg = null;
            updateProfile.reset("password", "confirmPassword", "image");
            setTimeout(() => {
                flash.value.status = null;
                flash.value.message = null;
            }, 3000);
        },
    });
};

const profileRef = ref();
const cropper = ref();
let cropModel = ref();
const currentImage = reactive({
    imgSrc: null,
    cropImg: null,
});

onMounted(() => {
    cropModel = new bootstrap.Modal(document.getElementById("img-upload-modal"), {
        keyboard: false,
    });
});

const hideCropper = () => {
    currentImage.imgSrc = null;
    profileRef.value.value = null;
};

const deleteImage = () => {
    currentImage.imgSrc = null;
    currentImage.cropImg = null;
    updateProfile.image = null;
};

const cropImage = () => {
    if (cropper.value) {
        const { canvas } = cropper.value.getResult();
        currentImage.cropImg = canvas.toDataURL();
        const sizeInBytes = currentImage.cropImg.length;

        // Convert bytes to megabytes
        const sizeInMB = sizeInBytes / (1024 * 1024);
        const maxSizeMB = 2;
        if (sizeInMB > maxSizeMB) {
            const shortenedDataURL = canvas.toDataURL("image/jpeg", 0.5);
            updateProfile.image = shortenedDataURL;
        } else {
            updateProfile.image = currentImage.cropImg;
        }
        hideCropper();
        cropModel.hide();
    }
};

const setProfileImage = (event) => {
    var input = event.target;
    let file = input.files[0];
    flash.value.status = null;
    flash.value.message = null;

    if (file.type.split("/")[0] !== "image") {
        profileRef.value.value = null;
        props.errors.image = "Allowed Image Type: png,jpg,jpeg";
        setTimeout(() => {
            flash.value.status = null;
            flash.value.message = null;
        }, 3000);
        event.preventDefault();
        return false;
    }

    if (typeof FileReader === "function") {
        var size = (file.size / 1024 / 1024).toFixed(2);
        const maxSize = 10;
        // maxSize is MB...
        if (size > maxSize) {
            props.errors.image = `Image is too long. Maximum length is ${maxSize}MB.`;
            profileRef.value.value = null;
            return false;
        }
        // Ensure that you have a file before attempting to read it

        if (input.files && file) {
            var reader = new FileReader();
            reader.onload = (e) => {
                currentImage.imgSrc = e.target.result;
            };
            props.errors.image = "";
            reader.readAsDataURL(file);
            cropModel.show(); // show modal
        }
    } else {
        flash.value.status = "error";
        flash.value.message = "Sorry, FileReader API not supported";
        setTimeout(() => {
            flash.value.status = null;
            flash.value.message = null;
        }, 3000);
    }
};
</script>

<script>
import AuthLayout from "@/Layouts/AuthenticatedLayout.vue";
export default {
    layout: AuthLayout,
};
</script>

<template>
    <Head title="Edit Profile" />
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-1">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1">Edit Profile</h4>
            <p class="text-muted">edit profile as needed</p>
        </div>
    </div>

    <form @submit.prevent="update">
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card p-1 h-100">
                    <div class="card-body mb-3">
                        <div class="profile-avatar-section">
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-md-12 text-center">
                                        <img class="img-fluid rounded mb-3 pt-1 mt-4 cursor-pointer"
                                            :src="currentImage.cropImg || resolveImageURL(user.image)" height="250"
                                            width="250" alt="Upload Image" title="Upload Profile Images" />
                                        <input type="file" ref="profileRef" id="fileInput" style="display: none"
                                            @change="setProfileImage" />
                                    </div>
                                    <div class="col-md-12 d-flex gap-2 justify-content-center">
                                        <button type="button" class="btn btn-sm btn-primary cursor-pointer"
                                            @click="profileRef.click()">
                                            Browse
                                        </button>
                                        <button type="button" v-if="currentImage.cropImg"
                                            class="btn btn-sm btn-secondary cursor-pointer" @click="deleteImage()">
                                            Reset
                                        </button>
                                    </div>

                                    <span class="text-danger text-center" v-if="errors.image">
                                        {{ errors.image }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card p-1 mb-3 h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Details</h5>
                    </div>
                    <div class="card-body mb-2">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="Name">
                                        Name <span class="text-danger">*</span> :
                                    </label>
                                    <input type="text" class="form-control" placeholder="Enter Name"
                                        v-model="updateProfile.name" autofocus />
                                    <div class="text-danger" v-if="errors.name">
                                        {{ errors.name }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="Email">
                                        Email <span class="text-danger">*</span> :
                                    </label>
                                    <input type="text" class="form-control" placeholder="example@mail.com"
                                        v-model="updateProfile.email" />
                                    <div class="text-danger" v-if="errors.email">
                                        {{ errors.email }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Password" class="form-label">
                                        Password :
                                    </label>
                                    <input type="password" v-model="updateProfile.password" class="form-control"
                                        placeholder="*******" />
                                    <div class="text-danger" v-if="errors.password">
                                        {{ errors.password }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ConfirmPassword" class="form-label">
                                        Confirm Password :
                                    </label>
                                    <input type="password" v-model="updateProfile.confirmPassword" class="form-control"
                                        placeholder="*******" />
                                    <div class="text-danger" v-if="errors.confirmPassword">
                                        {{ errors.confirmPassword }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4"></div>
            <div class="col-md-8">
                <button type="submit" class="btn btn-primary waves-effect me-2 cursor-pointer">
                    Save Changes
                </button>
                <Link :href="route('dashboard')" class="btn btn-outline-secondary waves-effect cursor-pointer">
                Discard
                </Link>
            </div>
        </div>
    </form>

    <!-- Cropper Model -->
    <div class="modal fade img-upload-modal" id="img-upload-modal" tabindex="-1" role="dialog" backdrop="static"
        aria-labelledby="imgModal" aria-hidden="true">
        <div class="modal-dialog model-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imgModal">Crop Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <Cropper ref="cropper" class="cropper" :src="currentImage.imgSrc"
                        :stencil-props="{ aspectRatio: 5 / 5 }" />
                </div>

                <div class="modal-footer">
                    <a href="javascript:void(0);" @click="hideCropper"
                        class="btn btn-link link-success fw-medium cursor-pointer" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1 align-middle"> </i>
                        Discard
                    </a>
                    <button type="button" class="btn btn-primary cursor-pointer" @click="cropImage">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Cropper Model ENDS -->
    <Toast v-if="flash.status" />
</template>
