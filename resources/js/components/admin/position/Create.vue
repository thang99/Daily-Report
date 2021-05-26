<template>
    <div class="modal fade" id="createPositionModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Position</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form @submit.prevent="createPosition" method="post">
                <div class="modal-body">
                    <div class="alert text-white bg-success" role="alert"  v-if="success">
                        <div class="iq-alert-text">Create a position success</div>
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
                                checked=""
                                id="positionSwitch"
                                >
                                <label class="custom-control-label" for="positionSwitch">Active Switch</label>
                            </div>
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
</template>

<script>
    export default {
       data() {
            return {
                form : {},
                errors: {},
                success : false
            }
        },
        mounted () {
            this.form.status = 1;
        },
       
        methods: {
            setTimeOut () {
                this.timeout = setTimeout(() => {
                    this.success = false;
                },3000);
            },
            createPosition() {
                axios.post('/api/admin/positions', this.form )
                .then((res) => {
                    this.form= {};
                    this.form.status = 0;
                    this.success = true;
                    this.errors = {};
                    this.$emit('CreatedPosition');
                    this.setTimeOut();
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

<style >

</style>