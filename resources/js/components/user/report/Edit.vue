<template>
    <div class="row">
        <nav aria-label="breadcrumb" style="margin-left:15px">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/user-reports/list">List my report</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit my report</li>
            </ol>
        </nav>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Edit Report</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form @submit.prevent="editReport" method="put">
                        <div class="body">
                            <div class="alert text-white bg-success" role="alert" v-if="success">
                                <div class="iq-alert-text">Edit report success</div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="ri-close-line"></i>
                                </button>
                            </div>
                            <div class="alert text-white bg-danger" role="alert" v-if="message">
                                <div class="iq-alert-text">{{message}}</div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="ri-close-line"></i>
                                </button>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label>Title:</label>
                                    <input type="text" v-model="report.title" class="form-control">
                                    <div class="text-danger" v-if="errors && errors.title">{{errors.title[0]}}</div>
                                </div>
                            </div>
                            <div class="form-group mt-4">
                                <label>Content:</label>
                                <textarea class="form-control" rows="5" v-model="report.content"></textarea>
                                <div class="text-danger" v-if="errors && errors.content">{{errors.content[0]}}</div>
                            </div>
                        </div>
                        <div class="footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="/user-reports/list" role="button" class="btn btn-danger">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Edit",
    props: ['report'],
    data() {
        return {
            errors: {},
            success : false,
            timeout: null,
            message: '',
        }
    },
    methods: {
        setTimeOut () {
            this.timeout = setTimeout(() => {
                this.success = false;
            },3000);
        },
        editReport() {
            axios.put('/api/user-reports/'+this.report.id,{
                title : this.report.title,
                content : this.report.content,
            })
            .then(response => {
                if(response.data.message) {
                    this.message = response.data.message;
                    setTimeout( ()=> (window.location.href='/user-reports/list'),3000);
                } else {
                    this.success = true;
                    this.errors = {};
                    this.setTimeOut();
                }              
            })
            .catch(errors => {
                if(errors && errors.response.status == 422) {
                    this.errors = errors.response.data.errors;
                }
                this.success = false;
            });
        }
    },
}
</script>

<style scoped>

</style>
