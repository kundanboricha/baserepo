<script setup>
import { ref } from 'vue';
import { useForm, Head, Link, usePage } from "@inertiajs/vue3";
import Toast from "@/Components/Miscs/Toast.vue";
import Multiselect from "@vueform/multiselect";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { useSelectOptions } from '@/Compasable/selectOptions';
import { useGeneral } from '@/Compasable/General';

const { asset, resolveImageURL } = useGeneral();
const { statusOptions } = useSelectOptions();

const props = defineProps({
  user: [Array, Object],
  errors: [Object, null],
});

const page = usePage();
const flash = ref(page.props.flash);

const reveal = (field) => {
  const input = document.getElementById(field);
  if (input.type == "password") {
    input.type = "text";
  } else {
    input.type = "password";
  }
};

const updateUserForm = useForm({
  id: props.user.id,
  name: props.user.name,
  email: props.user.email,
  password: "",
  confirmPassword: "",
  role: props.user.role,
  image: null,
  status: props.user.status,
});

const update = () => {
  updateUserForm.post(route("users.update"));
};

</script>
<script>
import AuthLayout from "@/Layouts/AuthenticatedLayout.vue";
export default {
  layout: AuthLayout,
};
</script>


<template>
  <Head title="Edit User" />
  <h4 class="py-3 mb-2">
    <span class="text-muted fw-light">Users / </span>Edit User
  </h4>
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-1">
    <div class="d-flex flex-column justify-content-center">
      <h4 class="mb-1">Edit User</h4>
      <p class="text-muted">Modify user details as needed</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-8">
      <form @submit.prevent="update">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Details</h5>
            <!-- <small class="text-muted float-end">Default label</small> -->
          </div>
          <div class="card-body">

            <div class="row mt-1">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label" for="Name">
                    Name <span class="text-danger">*</span> :
                  </label>
                  <input type="text" class="form-control" placeholder="Name" v-model="updateUserForm.name" autofocus>
                  <div class="text-danger" v-if="errors.name">{{ errors.name }}</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label" for="Email">
                    Email <span class="text-danger">*</span> :
                  </label>
                  <input type="text" class="form-control" placeholder="johndoe@gmail.com" v-model="updateUserForm.email">
                  <div class="text-danger" v-if="errors.email">{{ errors.email }}</div>
                </div>
              </div>
            </div>

            <div class="row mt-1">
              <div class="col-md-6">
                <label class="form-label" for="Password">
                  Password <span class="text-danger">*</span> :
                </label>
                <div class="input-group input-group-merge form-password-toggle">
                  <input class="form-control form-control-merge" type="password" placeholder="············"
                    aria-describedby="login-password" v-model="updateUserForm.password" id="password" />
                  <span class="input-group-text cursor-pointer">
                    <font-awesome-icon :icon="['fad', 'eye']" @click="reveal('password')" />
                  </span>
                </div>
                <div class="text-danger" v-if="errors.password">{{ errors.password }}</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="ConfirmPassword">
                  Confirm Password <span class="text-danger">*</span> :
                </label>
                <div class="input-group input-group-merge form-password-toggle">
                  <input class="form-control form-control-merge" type="password" placeholder="············"
                    aria-describedby="login-password" v-model="updateUserForm.confirmPassword" id="confirmPassword" />
                  <span class="input-group-text cursor-pointer">
                    <font-awesome-icon :icon="['fad', 'eye']" @click="reveal('confirmPassword')" />
                  </span>
                </div>
                <div class="text-danger" v-if="errors.confirmPassword">{{ errors.confirmPassword }}</div>
              </div>
            </div>

            <div class="row mt-1">
              <div class="col-md-6">
                <label class="form-label " for="Image">
                  Profile Image:
                </label>
                <input type="file" class="form-control" @input="updateUserForm.image = $event.target.files[0]">
                <div class="text-danger" v-if="errors.image">{{ errors.image }}</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="Status">Status: </label>
                <Multiselect v-model="updateUserForm.status" :searchable="true" :options="statusOptions" mode="single"
                  :close-on-select="true" placeholder="Select Status " />
                <div class="text-danger" v-if="errors.status">{{ errors.status }}</div>
              </div>
            </div>

          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary me-2 waves-effect">Save Changes</button>
            <Link :href="route('users.index')" class="btn btn-outline-secondary  waves-effect">Discard</Link>
          </div>
        </div>
      </form>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <img :src="resolveImageURL(user.image)" class="img-fluid" alt="">
        </div>
      </div>
    </div>
  </div>

  <Toast v-if="flash.status" />
</template>
