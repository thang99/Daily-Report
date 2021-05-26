<template>
    <div class="modal fade" id="editDivisionModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Division</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form @submit.prevent="editDivision" method="put">
                <div class="modal-body">
                     <div class="alert text-white bg-success" role="alert" v-show="success">
                        <div class="iq-alert-text">Edit a division success</div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ri-close-line"></i>
                        </button>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <p>Name</p>
                            <input type="text"  class="form-control" name="name" v-model.lazy="detail_division.name">
                            <div class="text-danger" v-if="errors && errors.name">{{errors.name[0]}}</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <p>Status</p>
                            <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" 
                                 v-model.lazy="detail_division.status"
                                class="custom-control-input" 
                                :id="`customSwitch${detail_division.id}`"
                                >
                                <label class="custom-control-label" :for="`customSwitch${detail_division.id}`">Active Switch</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Select Manager</label>
                        <select class="form-control mb-3" v-model.lazy="detail_division.user_id">
                            <option :value="null">--No-select--</option>
                           <option v-for="manager in listEditManager" :key="manager.id" :value="manager.id" >{{manager.name}}</option>
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
                division_data: {},
                errors: {},
                success : false,
                timeout : null,
                listManager : {},
                list_division : {}
            }
        },
        props: {
            detail_division: {
                type: Object,
            },
            listEditManager: {
                type: Array,
            }
        },
        methods: {
            setTimeOut () {
                this.timeout = setTimeout(() => {
                    this.success = false;
                },3000);
            },
            editDivision() {
                axios.put('/api/admin/divisions/'+ this.detail_division.id, this.detail_division)
                .then((res) => {
                this.success = true;
                this.errors = {};
                this.setTimeOut();
                // this.$bus.emit('EmitEditDivision',this.getAllDivision());
                this.$emit('UpdateDivision');
                })
                .catch((errors) => {
                if(errors && errors.response.status == 422) {
                this.errors = errors.response.data.errors;
                }
                this.success = false;
                });
            },
            getAllDivision() {
                axios.get('/api/admin/divisions-all')
                .then((res) => {
                    this.list_division = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>