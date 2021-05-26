<template>
 <div class="row">
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb iq-bg-primary">
                <li class="breadcrumb-item"><a href="/home"><i class="ri-home-4-line mr-1 float-left"></i>Home</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="/admin/manager-users">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <div class="header-title">
            <h4 class="card-title">Create user</h4>
          </div>
        </div>
        <div class="card-body">
          <div class="alert text-white bg-success" role="alert" v-if="success">
            <div class="iq-alert-text">Create a user success</div>
            <button
              type="button"
              class="close"
              data-dismiss="alert"
              aria-label="Close"
            >
              <i class="ri-close-line"></i>
            </button>
          </div>
          <form
            enctype="multipart/form-data"
            @submit.prevent="createUser"
            method="post"
          >
            <div class="form-row">
              <div class="col-md-4 mb-3">
                <label for="exampleInputText1">Name </label>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Enter Name"
                  v-model="formData.name"
                />
                <div class="text-danger" v-if="errors && errors.name">
                  {{ errors.name[0] }}
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="exampleInputEmail2">Email</label>
                <input
                  type="email"
                  class="form-control"
                  placeholder="Enter Email"
                  v-model="formData.email"
                />
                <div class="text-danger" v-if="errors && errors.email">
                  {{ errors.email[0] }}
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="exampleInputText1">Phone </label>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Enter Phone"
                  v-model="formData.phone"
                />
                <div class="text-danger" v-if="errors && errors.phone">
                  {{ errors.phone[0] }}
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="exampleInputEmail2">Birthday</label>
                <input
                  type="date"
                  class="form-control"
                  v-model="formData.birthday"
                />
                <div class="text-danger" v-if="errors && errors.birthday">
                  {{ errors.birthday[0] }}
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <p>Role</p>
                <div class="checkbox d-inline-block mr-3" v-for="option in options" :key="option.value">
                  <input type="checkbox" class="checkbox-input" :id="option.value" v-model="role_checked" :name="option.value" :value="option.value">
                  <label >{{option.text}}</label>
                </div>
                <div class="text-danger" v-if="errors && errors.role">
                  {{ errors.role[0] }}
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <div
                  class="custom-control custom-switch custom-switch-text custom-control-inline"
                >
                  <div class="custom-switch-inner">
                    <p class="mb-0">Status</p>
                    <input
                      type="checkbox"
                      class="custom-control-input"
                      id="customSwitch-11"
                      checked=""
                      v-model="formData.status"
                    />
                    <label
                      class="custom-control-label"
                      for="customSwitch-11"
                      data-on-label="On"
                      data-off-label="Off"
                    >
                    </label>
                    <div class="text-danger" v-if="errors && errors.status">
                      {{ errors.status[0] }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="exampleInputText1">Password </label>
                <input
                  type="password"
                  class="form-control"
                  placeholder="Enter Password"
                  v-model="formData.password"
                />
                <div class="text-danger" v-if="errors && errors.password">
                  {{ errors.password[0] }}
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="exampleInputEmail2">Confirm Password </label>
                <input
                  type="password"
                  class="form-control"
                  placeholder="Enter Confirm Password"
                  v-model="formData.confirm_password"
                />
                <div class="text-danger" v-if="errors && errors.confirm_password">
                  {{ errors.confirm_password[0] }}
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-5 mb-3">
                <label for="exampleInputPassword4">Avatar</label>
                <div class="custom-file">
                  <input
                    type="file"
                    ref="fileImage"
                    name="avatar"
                    class="custom-file-input"
                    @change="uploadImage"
                  />
                  <label class="custom-file-label" for="customFile"
                    >Choose file</label
                  >
                </div>
                <img
                  :src="previewImage"
                  alt=""
                  style="max-width: 200px; max-height: 200px"
                  class="mt-1"
                />
                <div class="text-danger" v-if="errors && errors.avatar">
                  {{ errors.avatar[0] }}
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-plus" aria-hidden="true"></i>Add
            </button>
            <button type="reset" class="btn bg-danger">
              <i class="fa fa-refresh" aria-hidden="true"></i>Cancel
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      formData: {
        name: "",
        birthday: "",
        phone: "",
        email: "",
        password: "",
        status: "",
      },
      avatar: "",
      errors: {},
      success: false,
      previewImage: null,
      success: false,
      role_checked : ['user'],
      options: [
        { text: 'Admin' , value: 'admin'},
        { text: 'User' , value: 'user'},
      ]
    };
  },
  mounted() {
    this.formData.status = 1;
  },
  methods: {
    setTimeOut() {
      this.timeout = setTimeout(() => {
        this.success = false;
      }, 3000);
    },
    uploadImage(e) {
      const image = e.target.files[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = (e) => {
        this.previewImage = e.target.result;
      };
      this.avatar = image;
    },
    createUser() {
      const config = {
        headers: {
          "content-type": "multipart/form-data",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
            .content,
        },
      };
      // form data
      let formData = new FormData();
      formData.append("avatar", this.avatar);
      formData.append("role", this.role_checked);
      _.each(this.formData, (value, key) => {
        formData.append(key, value);
      });
      
      axios
        .post("/api/admin/users", formData, config)
        .then((res) => {
          (this.formData = {}), (this.formData.status = 0);
          this.role_checked = [];
          this.previewImage = null;
          this.$refs.fileImage.value = null;
          this.avatar = "";
          $('.custom-file-label').html('Choose file');
          this.success = true;
          this.errors = {};
          this.setTimeOut();
        })
        .catch((errors) => {
          if (errors && errors.response.status == 422) {
            this.errors = errors.response.data.errors;
          }
          this.success = false;
        });
    },
  },
};
</script>

<style>
</style>