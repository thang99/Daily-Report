<template>
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb iq-bg-primary">
                    <li class="breadcrumb-item"><a href="/home"><i class="ri-home-4-line mr-1 float-left"></i>Home</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="/admin/manager-users">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                    <h4 class="card-title">Edit user <span v-if="check_manager">(Manager- {{info_Division[0].name_div}})</span></h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert text-white bg-success" role="alert" v-if="success" >
                        <div class="iq-alert-text">Edit a user success</div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ri-close-line"></i>
                        </button>
                    </div>
                    <form enctype="multipart/form-data" @submit.prevent="editUser" method="put" >
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="exampleInputText1">Name </label>
                                <input type="text" class="form-control"  placeholder="Enter Name" v-model="formData.name" disabled>
                                <div class="text-danger" v-if="errors && errors.name">{{errors.name[0]}}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="exampleInputEmail2">Email</label>
                                <input type="email" class="form-control"   placeholder="Enter Email" v-model="formData.email" disabled>
                                <div class="text-danger" v-if="errors && errors.email">{{errors.email[0]}}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="exampleInputText1">Phone </label>
                                <input type="text" class="form-control"  placeholder="Enter Phone" v-model="formData.phone" disabled>
                                <div class="text-danger" v-if="errors && errors.phone">{{errors.phone[0]}}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="exampleInputEmail2">Birthday</label>
                                <input type="date" class="form-control"   v-model="formData.birthday" disabled>
                                <div class="text-danger" v-if="errors && errors.birthday">{{errors.birthday[0]}}</div>
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
                                <div class="custom-control custom-switch custom-switch-text custom-control-inline">
                                    <div class="custom-switch-inner">
                                    <p class="mb-0"> Status </p>
                                    <input type="checkbox" class="custom-control-input" id="customSwitch-11" checked="" v-model="formData.status">
                                    <label class="custom-control-label" for="customSwitch-11" data-on-label="On" data-off-label="Off">
                                    </label>
                                    <div class="text-danger" v-if="errors && errors.status">{{errors.status[0]}}</div>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                        <div class="form-row">
                            <div class="col-md-5 mb-3">
                                <label for="exampleInputPassword4">Avatar</label>
                                <div class="custom-file">
                                    <input type="file" ref="file" name="avatar" class="custom-file-input" @change="uploadImage">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                <img :src="previewImage" alt="" style="max-width:200px;max-height:200px" class="mt-1">
                                <div class="text-danger" v-if="errors && errors.avatar">{{errors.avatar[0]}}</div>
                            </div>
                        
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i>Edit</button>
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
                    name: '',
                    birthday: '',
                    phone: '',
                    email: '',
                    password: '',
                    status:  '',
                },
                avatar: '',
                errors: {},
                success : false,
                previewImage: null,
                success : false,
                role_checked : [],
                options: [
                    { text: 'Admin' , value: 'admin'},
                    { text: 'User' , value: 'user'},
                ],
                check_manager : false,
                info_Division : [],
            }
        },
        props: {
            id_user: {
                type: Number,
            }
        },
        mounted () {
            this.formData.status = 1;
            axios.get(`/api/admin/users/${this.id_user}`)
            .then((res) => {
                const role_user = res.data.data.roles;
                const arr_roles = [];
                role_user.forEach(function(role) {
                    arr_roles.push(role.name);
                })
                this.role_checked = arr_roles;
                this.formData = res.data.data;
                this.previewImage = `/images/users/${this.formData.avatar}`;
            })
            .catch((errors) => {

            })
            this.checkManagerDivision();
        },
        methods: {
            setTimeOut () {
                this.timeout = setTimeout(() => {
                    this.success = false;
                },3000);
            },
            uploadImage(e){
                const image = e.target.files[0];
                const reader = new FileReader();
                reader.readAsDataURL(image);
                reader.onload = e =>{
                    this.previewImage = e.target.result;
                };
                this.avatar = image;
            },
            editUser() {
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                }
                // form data
                let formData = new FormData();
                this.setFormEdit(formData);
                axios.post(`/api/admin/users/${this.id_user}`, formData ,config)
                .then((res) => {
                    this.success = true;
                    this.errors = {};
                    this.setTimeOut();
                })
                .catch((errors) => {
                if(errors && errors.response.status == 422) {
                    this.errors = errors.response.data.errors;
                }
                this.success = false;
                }); 
            },
            setFormEdit(formData)
            {
                if( this.avatar != ''){
                    formData.append("avatar", this.avatar);
                }
                formData.append("role", this.role_checked);
                formData.append("name", this.formData.name);
                formData.append("email", this.formData.email);
                formData.append("phone", this.formData.phone);
                formData.append("birthday", this.formData.birthday);
                formData.append("status", this.formData.status);
                formData.append('_method', 'PUT');
            },
            checkManagerDivision() {
                 axios.get(`/api/admin/user-manager-division/${this.id_user}`)
                .then((res) => {
                    this.info_Division = res.data.data;
                    if(this.info_Division.length > 0)
                    {
                        this.check_manager = true;
                    }
                })
                .catch((errors) => {

                })
            }
        },
        
    }
</script>

<style>

</style>