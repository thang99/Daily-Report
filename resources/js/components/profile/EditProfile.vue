<template>
  <div class="row">
            <div class="col-lg-12">
               <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="/home">Home</a></li>
                     <li class="breadcrumb-item active" aria-current="page">Edit</li>
                  </ol>
               </nav>
               <div class="card">
                  <div class="card-body p-0">
                     <div class="iq-edit-list usr-edit">
                        <ul class="iq-edit-profile d-flex nav nav-pills">
                           <li class="col-md-6 p-0">
                              <a class="nav-link active" data-toggle="pill" href="#personal-information">
                              Personal Information
                              </a>
                           </li>
                           <li class="col-md-6 p-0">
                              <a class="nav-link" data-toggle="pill" href="#chang-pwd">
                              Change Password
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-12">
               <div class="iq-edit-list-data">
                  <div class="tab-content">
                     <div class="tab-pane fade active show" id="personal-information" role="tabpanel">
                        <div class="card">
                           <div class="card-header d-flex justify-content-between">
                              <div class="iq-header-title">
                                 <h4 class="card-title">Personal Information</h4>
                              </div>
                           </div>
                           <div class="card-body">
                              <form @submit.prevent="changeProfile" method="post" enctype="multipart/form-data">
                                <div class="alert text-white bg-success" role="alert" v-if="success">
                                    <div class="iq-alert-text">Edit profile success</div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="ri-close-line"></i>
                                    </button>
                                </div>
                                 <div class="row align-items-center">
                                    <div class="form-group col-md-12">
                                       <label for="uname">Name:</label>
                                       <input type="text" class="form-control" id="uname" v-model="user.name" name="name">
                                       <div class="text-danger" v-if="errors && errors.name">{{errors.name[0]}}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                       <label for="dob1">Date Of Birth:</label>
                                       <input class="form-control" type="date" id="dob1" v-model="user.birthday" name="birthday">
                                       <div class="text-danger" v-if="errors && errors.birthday">{{errors.birthday[0]}}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                       <label for="dob2">Phone:</label>
                                       <input class="form-control" type="text" id="dob2" v-model="user.phone" name="phone">
                                       <div class="text-danger" v-if="errors && errors.phone">{{errors.phone[0]}}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                       <label>Avatar:</label>
                                       <div>
                                          <img :src="image" alt="avatar_user">
                                          <input class="form-control-file" @change="onFileChange" type="file" name="avatar" accept="image/*">
                                       </div>
                                       <div class="text-danger" v-if="errors && errors.avatar">{{errors.avatar[0]}}</div>
                                    </div>
                                 </div>
                                 <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                 <button type="reset" class="btn btn-danger">Cancel</button>
                              </form>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="chang-pwd" role="tabpanel">
                        <edit-password :user="user"></edit-password>
                     </div>
                  </div>
               </div>
            </div>
        </div>
</template>

<script>
import EditPassword from './EditPassword.vue';
export default {
   components: {EditPassword},
   props: ['user'],
   data() {
     return {
        success: false,
        errors: {},
        timeout : null,
        image : ""
      }
   },
   mounted () {
      this.image = '/images/users/' + this.user.avatar;
   },
   methods: {
      setTimeOut () {
         this.timeout = setTimeout(() => {
            this.success = false;
         },3000);
      },
      onFileChange(event) {
				var input = event.target;
				if (input.files && input.files[0]) {
						var reader = new FileReader();
						reader.onload = (e) => {
							this.image = e.target.result;
						}
						reader.readAsDataURL(input.files[0]);
				}
				this.user.avatar = input.files[0];
      },
      changeProfile() {  
            var formData = new FormData();
            formData.append('name', this.user.name);
            formData.append('phone', this.user.phone);
            formData.append('birthday', this.user.birthday);
            formData.append('id', this.user.id);
            formData.append('avatar',this.user.avatar);
            formData.append('_method', 'PUT');
            
            axios.post('/api/profiles/'+this.user.id, formData, {
               headers: {'content-type': 'multipart/form-data'}
            })
            .then(response => {
               this.success = true,
               this.errors = {},
               this.setTimeOut()
            })
            .catch(errors => {
               if(errors && errors.response.status == 422) {
                  this.errors = errors.response.data.errors;
               }
                  this.success = false;
            });
      },
    },
}
</script>

<style scoped>
img {
   width: 90px;
   height:90px;
   border-radius: 50%;
}
</style>