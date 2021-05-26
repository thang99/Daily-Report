<template>
    <div class="modal fade" id="myModal" ref="modal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form @submit.prevent="abc" method="post">
                    <div class="modal-body">
                        <div class="alert text-white bg-success" role="alert" v-if="success">
                            <div class="iq-alert-text">Send feedback success</div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                        <div class="form-group">
                            <label>Message:</label>
                            <textarea class="form-control" rows="5" v-model="form.message"></textarea>
                            <div class="text-danger" v-if="errors && errors.message">{{ errors.message[0] }}</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['id_manager','id_user','id_report','option','listReports','search'], 
    data() {
        return {
            form: {
                message: '',
            },
            status: '',
            errors: {},
            success : false,
            timeout: null,
        }
    },
    mounted () {
        console.log('id_user: '+this.id_user);
        console.log('id manager: '+this.id_manager);
    },
    methods: {
        setTimeOut () {
            this.timeout = setTimeout(() => {
                this.success = false;
            },3000);
        },
        sendFeedback() {
            axios.post('/api/reports/feedback',{
                id_manager: this.id_manager,
                id_user: this.id_user,
                id_report: this.id_report,
                message: this.form.message 
            })
            .then(response => {
                this.form = {},
                this.success = true;
                this.errors = {};
                this.setTimeOut();
                setTimeout(()=> { $('#myModal').modal('toggle') },2000);
            })
            .catch(errors => {
                if (errors && errors.response.status == 422) {
                    this.errors = errors.response.data.errors;
                }
                this.success = false;
            })
        },
        changeData(user_id) {
            axios.patch('/api/reports/' + this.id_report, {
                status: this.status,
                user_report_id: user_id,
                user_feedback_id: this.id_manager,
            })
            .then(response => {
                this.listReports1 = response.data.data;
                this.search();
            })
            .catch(error => {
                console.log(error);
            });
        },
        changeStatus(user_id) {   
            if (this.option == 1) {
                this.status = 1;
                this.changeData(user_id);
            } else if (this.option == 0) {
                this.status = 0;
                this.changeData(user_id);
            } else {
                this.status = -1;
                this.changeData(user_id);
            }
        },

        abc() {
            this.sendFeedback();
            this.changeStatus(this.id_user);
        }
    },
    computed: {
        listReports1: {
            get() {
                return this.listReports
            },
            set() {
                this.$emit('update:', this.listReports);
            }
        }
    },
}
</script>

<style scoped>

</style>