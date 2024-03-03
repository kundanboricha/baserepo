<script setup>
import { reactive, ref, onMounted } from 'vue';
import { useForm, Head, Link, usePage } from "@inertiajs/vue3";
import Toast from "@/Components/Miscs/Toast.vue";
import { Cropper } from 'vue-advanced-cropper'
import 'vue-advanced-cropper/dist/style.css';
import Multiselect from "@vueform/multiselect";
import { useSelectOptions } from '@/Compasable/selectOptions';
import { useGeneral } from '@/Compasable/General';
const props = defineProps({
  errors: [Object, null],
});

const { asset } = useGeneral();
const { roleOptions } = useSelectOptions();

const page = usePage();
const flash = ref(page.props.flash);

const addUserForm = useForm({
  name: "",
  email: "",
  role: null,
  image: null,
});

const addUser = () => {
  addUserForm.post(route("users.store"));
};

// Cropper
const currentImage = reactive({
  imgSrc: null,
  cropImg: null,
});
const profileRef = ref();
const cropper = ref();
let cropModel = ref();

onMounted(() => {
  cropModel = new bootstrap.Modal(document.getElementById('img-upload-modal'), {
    keyboard: false
  })
})

const hideCropper = () => {
  currentImage.imgSrc = null;
  currentImage.cropImg = null;
  profileRef.value.value = null;
}

const deleteImage = () => {
  currentImage.cropImg = null;
  currentImage.imgSrc = null;
  profileRef.value.value = null;
}

const cropImage = () => {
  if (cropper.value) {
    props.errors.profile = "";
    const { canvas } = cropper.value.getResult();
    const image = {
      id: null,
      cropImg: canvas.toDataURL(),
      imgSrc: cropper.value.getResult().image.src
    };
    const sizeInBytes = image.cropImg.length;
    // Convert bytes to megabytes
    const sizeInMB = sizeInBytes / (1024 * 1024);
    const maxSizeMB = 2;
    if (sizeInMB > maxSizeMB) {
      const shortenedDataURL = canvas.toDataURL('image/jpeg', 0.5);
      addUserForm.image = shortenedDataURL;
    } else {
      addUserForm.image = image.cropImg;
    }
    currentImage.cropImg = image.cropImg;
    currentImage.imgSrc = image.imgSrc;
    cropModel.hide();
  }
}

const setProfileImage = (event) => {
  var input = event.target;
  let file = input.files[0];

  if (!file.type.includes("image/")) {
    props.errors.profile = "Please select an image: png,jpg,jpeg,webp";
    profileRef.value.value = null;
    setTimeout(() => {
      flash.value.status = null;
      flash.value.message = null;
    }, 3000);
    return false;
  }

  if (typeof FileReader === "function") {
    var size = parseFloat(file.size / (1024 * 1024)).toFixed(2);
    const MaxSize = 5;
    if (size > MaxSize) {
      event.preventDefault();
      props.errors.profile = `Image is too long. Maximum length is ${MaxSize}MB.`;
      profileRef.value.value = null;
      setTimeout(() => {
        flash.value.status = null;
        flash.value.message = null;
      }, 3000);
      return false;
    }
    // Ensure that you have a file before attempting to read it

    if (input.files && file) {
      var reader = new FileReader();
      reader.onload = (e) => {
        currentImage.imgSrc = e.target.result;
      };
      props.errors.image = ''
      reader.readAsDataURL(file);

      cropModel.show(); // show modal
    }
  } else {
    alert("Sorry, FileReader API not supported");
  }
}

</script>
<script>
import AuthLayout from "@/Layouts/AuthenticatedLayout.vue";
export default {
  layout: AuthLayout,
};
</script>
<template>
  <Head title="Add User" />

  <h4 class="py-3 mb-2">
    <span class="text-muted fw-light">Users / </span>Add User
  </h4>
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-1">
    <div class="d-flex flex-column justify-content-center">
      <h4 class="mb-1">Add User</h4>
      <p class="text-muted">Provide details for the new user</p>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <form @submit.prevent="addUser()">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Details</h5>
            <!-- <small class="text-muted float-end">Default label</small> -->
          </div>
          <div class="card-body">
            <div class="row mb-2">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label" for="Name">
                    Name <span class="text-danger">*</span> :
                  </label>
                  <input type="text" class="form-control" placeholder="Name" v-model="addUserForm.name" autofocus />
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
                  <input type="text" class="form-control" placeholder="johndoe@gmail.com" v-model="addUserForm.email" />
                  <div class="text-danger" v-if="errors.email">
                    {{ errors.email }}
                  </div>
                </div>
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-md-6">
                <label class="form-label" for="Image">
                  Profile Image :
                </label>
                <input type="file" ref="profileRef" class="form-control" @change="setProfileImage"
                  @dragover="setProfileImage" @drop="setProfileImage" id="uploadFile" />
                <div class="text-danger" v-if="errors.image">
                  {{ errors.image }}
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="AssignRole">
                  Role <span class="text-danger">*</span> :
                </label>
                <Multiselect v-model="addUserForm.role" :searchable="true" :options="roleOptions" mode="single"
                  :close-on-select="true" placeholder="Select Role for User" />
                <div class="text-danger" v-if="errors.role">
                  {{ errors.role }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary waves-effect me-2">
              Submit
            </button>
            <Link :href="route('users.index')" class="btn btn-outline-secondary waves-effect">Discard</Link>
          </div>
        </div>
      </form>
    </div>
    <div v-if="currentImage.cropImg" class="col-md-4">
      <div class="card">
        <div class="card-body">
          <button type="button" class="btn-close bg-white text-danger position-absolute border-0 right-0"
            @click="deleteImage()">
            <font-awesome-icon :icon="['fas', 'xmark']" size="xl" />
          </button>
          <img :src="currentImage.cropImg" class="img-fluid" alt="">
        </div>
      </div>
    </div>
  </div>

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
          <Cropper ref="cropper" class="cropper" :src="currentImage.imgSrc" :stencil-props="{ aspectRatio: 9 / 9 }" />
        </div>

        <div class="modal-footer ">
          <a href="javascript:void(0);" @click="hideCropper" class="btn btn-link link-success fw-medium"
            data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
          <button type="button" class="btn btn-primary " @click="cropImage">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Cropper Model ENDS -->
  <Toast v-if="flash.status" />
</template>
