<template>
    <div>
        <div class="modal fade" id="changePassModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form @submit.prevent="changePass" method="put">
                    <div class="modal-body">
                        <div class="alert text-white bg-success" role="alert"  v-if="success">
                            <div class="iq-alert-text">Change password success</div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="ri-close-line"></i>
                            </button>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <p>Current Password</p>
                                <input type="password" v-model="formData.currentPass" placeholder="Current Password" class="form-control"  >
                                <div class="text-danger" v-if="errors && errors.currentPass">{{errors.currentPass[0]}}</div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <p>New Password</p>
                                <input type="password" v-model="formData.newPass" placeholder="New Password"  class="form-control"  >
                                <div class="text-danger" v-if="errors && errors.newPass">{{errors.newPass[0]}}</div>
                            </div>
                             <div class="col-md-12 mb-3">
                                <p>Confirm Password</p>
                                <input type="password" v-model="formData.confirmPass" placeholder="Confirm Password" class="form-control"  >
                                <div class="text-danger" v-if="errors && errors.confirmPass">{{errors.confirmPass[0]}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            detail_user: {
                type: Object,
            }
        },
        data() {
            return {
                success: false,
                formData : {},
                errors : {}
            }
        },
        methods: {
            setTimeOutHiddenNoti() {
            this.timeout = setTimeout(() => {
                this.success = false;
            }, 3000);
            },
            changePass() {
                axios.put('/api/admin/user-change-pass/'+ this.detail_user.id, this.formData)
                .then((res) => {
                this.success = true;
                this.formData = {}
                this.errors = {};
                this.setTimeOutHiddenNoti();
                })
                .catch((errors) => {
                if(errors && errors.response.status == 422) {
                this.errors = errors.response.data.errors;
                }
                this.success = false;
                });
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>