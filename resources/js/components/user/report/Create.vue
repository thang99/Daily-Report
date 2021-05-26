<template>
    <div class="modal fade" id="createReportModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form @submit.prevent="createReport" method="post">
                    <div class="modal-body">
                        <div class="alert text-white bg-success" role="alert" v-if="success">
                            <div class="iq-alert-text">Create a report success</div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label>Title:</label>
                                <input type="text" v-model="form.title" class="form-control" @keydown="errors.title = ''">
                                <div class="text-danger" v-if="errors && errors.title">{{ errors.title[0] }}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Content:</label>
                            <textarea class="form-control" rows="5" v-model="form.content" @keydown="errors.content = ''"></textarea>
                            <div class="text-danger" v-if="errors && errors.content">{{ errors.content[0] }}</div>
                        </div>
                        <div class="form-group">
                            <label>Select Reviewer:</label>
                            <select class="form-control mb-3" v-model="form.assign_to" @change="errors.assign_to = ''">
                                <option v-for="manager in managers" :value="manager.id" :key="manager.id">{{ manager.name }}</option>
                            </select>
                            <div class="text-danger" v-if="errors && errors.assign_to">{{ errors.assign_to[0] }}</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Create",
    props: ['userId'],
    data() {
        return {
            form: {
                title: '',
                content: '',
                assign_to: '',
            },
            errors: {},
            success : false,
            timeout: null,
            managers:{},
        }
    },
    mounted() {
        this.loadManager();
    },
    methods: {
        setTimeOut () {
            this.timeout = setTimeout(() => {
                this.success = false;
            },3000);
        },
        createReport() {
            axios.post('/api/user-reports/list', {
                user_id: this.userId,
                title: this.form.title,
                content: this.form.content,
                assign_to: this.form.assign_to
            })
                .then(response => {
                    this.form = {},
                    this.success = true;
                    this.errors = {};
                    this.setTimeOut();
                    this.$emit('CreatedReport');
                })
                .catch((errors) => {
                    if (errors && errors.response.status == 422) {
                        this.errors = errors.response.data.errors;
                    }
                    this.success = false;
                });
        },
        loadManager() {
            axios.get('/api/user-reports/list/loadManager', {
                params: {
                    id: this.userId
                }
            })
            .then(response => {
                this.managers = response.data.data;
            })
            .catch(error => {
                console.log(error);
            })
        }
    },
}
</script>

<style scoped>

</style>
