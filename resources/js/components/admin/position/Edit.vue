<template>
    <div class="modal fade" id="editPositionModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Division</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form @submit.prevent="editPosition" method="put">
                <div class="modal-body">
                    <div class="alert text-white bg-success" role="alert"  v-if="success">
                        <div class="iq-alert-text">Edit a position success</div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ri-close-line"></i>
                        </button>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <p>Name</p>
                            <input type="text" v-model.lazy="detail_position.name" class="form-control"  >
                             <div class="text-danger" v-if="errors && errors.name">{{errors.name[0]}}</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <p>Status</p>
                            <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" 
                                v-model.lazy="detail_position.status"
                                class="custom-control-input"
                                checked=""
                                :id="`positionSwitchEdit${detail_position.id}`"
                                >
                                <label class="custom-control-label" :for="`positionSwitchEdit${detail_position.id}`">Active Switch</label>
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
                division_data: {},
                errors: {},
                success : false,
                timeout : null,
                listDivision: {},
            }
        },
        created () {
            axios.get(`/api/admin/divisions`)
            .then((response) => {
                this.listDivision = response.data.data;
            })
            .catch((error) => {
                 console.log(error);
            });;
        },
        props: {
            detail_position: {
                type: Object,
            }
        },
        methods: {
            setTimeOut () {
                this.timeout = setTimeout(() => {
                    this.success = false;
                },3000);
            },
            editPosition() {
                axios.put('/api/admin/positions/'+ this.detail_position.id, this.detail_position)
                .then((res) => {
                this.success = true;
                this.errors = {};
                this.setTimeOut();
                })
                .catch((errors) => {
                    console.log('err',this.detail_position);
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