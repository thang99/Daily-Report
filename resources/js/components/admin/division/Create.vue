<template>
    <div class="modal fade" id="createDivisionModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Division</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form @submit.prevent="createDivision" method="post">
                <div class="modal-body">
                    <div class="alert text-white bg-success" role="alert" v-show="success">
                        <div class="iq-alert-text">Create a division success</div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ri-close-line"></i>
                        </button>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <p>Name</p>
                            <input type="text" v-model="form.name" class="form-control"  >
                            <div class="text-danger" v-if="errors && errors.name">{{errors.name[0]}}</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <p>Status</p>
                            <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox"
                                v-model="form.status"
                                class="custom-control-input"
                                id="divisionSwitch"
                                checked=""
                                >
                                <label class="custom-control-label" for="divisionSwitch">Active Switch</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Select Manager</label>
                        <select class="form-control mb-3" v-model="form.user_id" >
                           <option selected disabled value>--No-select--</option>
                           <option v-for="manager in listUserManager" :key="manager.id" :value="manager.id" >{{manager.name}}</option>
                        </select>
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
</template>

<script>
    export default {
        data() {
            return {
                form : {},
                errors: {},
                success : false,
                timeout : null,
            }
        },
        props: {
            listUserManager: {
                type: Object,
            },
        },
        mounted () {
            this.form.status = 1;
            this.userManager();
        },
        methods: {
            setTimeOut () {
                this.timeout = setTimeout(() => {
                    this.success = false;
                },3000);
            },
            createDivision() {
                axios.post('/api/admin/divisions', this.form )
                .then((res) => {
                this.form = {};
                this.success = true;
                this.errors = {};
                this.form.status = 0;
                this.$emit('CreatedDivision');
                this.setTimeOut();
                })
                .catch((errors) => {
                if(errors && errors.response.status == 422) {
                    this.errors = errors.response.data.errors;
                }
                this.success = false;
                });
            },
        },
    }
</script>

<style lang="scss" scoped>

</style>
