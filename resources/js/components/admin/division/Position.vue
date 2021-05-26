<template>
    <div class="modal fade" id="postionDivisionModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Position To Division</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form @submit.prevent="createPositionDivision" method="post">
                <div class="modal-body">
                    <div class="alert text-white bg-success" role="alert" v-show="success">
                        <div class="iq-alert-text">Create a position-division success</div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ri-close-line"></i>
                        </button>
                    </div>
                    <div class="form-row">
                        <label>Select Division</label>
                        <select class="form-control mb-3" v-model="form.division_id">
                            <option v-for="division in list_division" :key="division.id" :value="division.id" >{{division.name}}</option>
                        </select>
                        <div class="text-danger" v-if="errors && errors.division_id">{{errors.division_id[0]}}</div>
                    </div>
                    <div class="form-group">
                        <label>Select Position</label>
                        <select class="form-control mb-3" v-model="form.position_id">
                           <option v-for="position in list_position" :key="position.id" :value="position.id" >{{position.name}}</option>
                        </select>
                        <div class="text-danger" v-if="errors && errors.position_id">{{errors.position_id[0]}}</div>
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
                list_division : {},
                list_position: {},
                valPosition : {},
                valDivision : {}
            }
        },
        created () {
            this.getAllDivision();
            this.getAllPosition();
        },
        methods: {
            setTimeOut () {
                this.timeout = setTimeout(() => {
                    this.success = false;
                },3000);
            },
            createPositionDivision() {
                axios.post('/api/admin/positions-divisions', this.form )
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
            getAllDivision() {
                axios.get('/api/admin/divisions-all')
                .then((res) => {
                    this.list_division = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
            },
            getAllPosition() {
                axios.get('/api/admin/positions-all')
                .then((res) => {
                    this.list_position = res.data.data;
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