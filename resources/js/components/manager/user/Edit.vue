<template>
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/manager/users">List user of division</a></li>
                <li class="breadcrumb-item active" aria-current="page">Change position of user in division</li>
            </ol>
        </nav>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Change position of user in division</h4>
                </div>
            </div>
            <div class="card-body">
                <form @submit.prevent="submit" method="put">
                    <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="success">
                        <div class="iq-alert-text">Change position success</div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="exampleInputText1">Name: </label>
                            <input type="text" class="form-control" :value="user[0].name" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3" v-if="Object.keys(this.division).length > 0">
                            <label for="validationCustom04">Division:</label>
                            <input type="text" class="form-control" :value="division[0].name" :id="division[0].id" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom04">Position:</label>
                            <select class="form-control" id="validationCustom04" name="position_id" v-model="user[0].position_id" @change="errors.position_id = ''">
                                <option :value="null"> --------- Select postions -------- </option>
                                <option v-for="position in listPositions" :key="position.id" :value="position.id">
                                    {{position.name}}
                                </option>
                            </select>
                            <div class="text-danger" v-if="errors && errors.position_id">
                                {{ errors.position_id[0] }}
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Edit</button>
                    <a href="/manager/users" class="btn btn-danger" role="button">Back</a>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['id','user'],
        data() {
            return {
                division : '',
                listPositions : [],
                success: false,
                errors: {},
                timeout : null
            }
        },
        mounted () {
            this.getDivision();
            this.getPosition();
        },
        methods: {
            setTimeOut () {
                this.timeout = setTimeout(() => {
                    this.success = false;
                },3000);
            },
            getDivision() {
                axios.get('/api/users/create/loadDivision',{
                    params: {
                        id: this.id
                    }
                })
                .then(response => {
                    this.division = response.data.data;
                })
                .catch(error => {
                    console.log(error);
                });
            },
            getPosition() {
                 axios.get('/api/users/create/loadPosition',{
                    params: {
                        id: this.id
                    }
                })
                .then(response => {
                    this.listPositions = response.data.data;
                })
                .catch(error => {
                    console.log(error);
                });
            },
            submit() {
                axios.put('/api/users/'+this.user[0].id+'/edit',{
                    'position_id': this.user[0].position_id,
                    'division_id': this.division[0].id,
                })
                .then(response => {
                    this.success = true;
                    this.errors = {};
                    this.setTimeOut();
                    // setTimeout( ()=> (window.location.href='/manager/users'),3000);
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            }
        },
    }
</script>

<style>

</style>
