<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="iq-header-title">
                <h4 class="card-title">Change Password</h4>
            </div>
        </div>
        <div class="card-body">
            <div class="alert text-white bg-success" role="alert" v-if="success">
                <div class="iq-alert-text">Edit password success</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ri-close-line"></i>
                </button>
            </div>
            <form method="put" @submit.prevent="changePassword">
                <div class="form-group">
                    <label for="cpass">Current Password:</label>
                    <input type="Password" class="form-control" id="cpass" v-model="password">
                    <div class="text-danger" v-if="errors && errors.password">{{errors.password[0]}}</div>
                </div>
                <div class="form-group">
                    <label for="npass">New Password:</label>
                    <input type="Password" class="form-control" id="npass" v-model="new_password" >
                    <div class="text-danger" v-if="errors && errors.new_password">{{errors.new_password[0]}}</div>
                </div>
                <div class="form-group">
                    <label for="vpass">Verify Password:</label>
                    <input type="Password" class="form-control" id="vpass" v-model="confirm_password">
                    <div class="text-danger" v-if="errors && errors.confirm_password">{{errors.confirm_password[0]}}</div>
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button type="reset" class="btn btn-danger">Cancel</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: ['user'],
    data() {
        return {
            success: false,
            errors: {},
            timeout : null,
            new_password : "",
            confirm_password: "",
            password: ""
        }
    },
    methods: {
        setTimeOut () {
         this.timeout = setTimeout(() => {
            this.success = false;
         },3000);
        },
        changePassword() {
         axios.put('/api/profiles/password/'+this.user.id, {
            new_password: this.new_password,
            confirm_password: this.confirm_password,
            password : this.password,
            id : this.user.id
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

<style>

</style>