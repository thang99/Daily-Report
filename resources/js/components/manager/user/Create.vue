<template>
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/manager/users">List user of division</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add user to division</li>
            </ol>
        </nav>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Add user to division</h4>
                </div>
            </div>
            <div class="card-body">
                <form @submit.prevent="submit" method="put">
                    <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="success">
                        <div class="iq-alert-text">Add user division success</div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="exampleInputText1">Name: </label>
                            <select class="form-control" id="validationCustom10" name="user_id" v-model="form.user_id" @change="errors.user_id = ''">
                                <option :value="null"> --------- Select user -------- </option>
                                <option v-for="user in listUsers" :key="user.id" :value="user.id">
                                    {{user.name}}
                                </option>
                            </select>
                            <div class="text-danger" v-if="errors && errors.user_id">
                                {{ errors.user_id[0] }}
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3" v-if="Object.keys(this.division).length > 0">
                            <label for="validationCustom04">Division:</label>
                            <input type="text" class="form-control" :value="division[0].name" :id="division[0].id" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom04">Position:</label>
                            <select class="form-control" id="validationCustom04" name="position_id" v-model="form.position_id" @change="errors.position_id = ''">
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
                    <button type="submit" class="btn btn-primary">Add</button>
                    <a href="/manager/users" class="btn btn-danger" role="button">Back</a>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['id'],
        data() {
            return {
                division : '',
                // division_id: '',
                // division_name: '',
                listPositions : [],
                listUsers : [],
                form: {
                    name : '',
                    user_id : '',
                    position_id: '',
                },
                success: false,
                errors: {},
                timeout : null
            }
        },
        mounted () {
            this.getDivision();
            this.getPosition();
            this.getUsers();
        },
        methods: {
            setTimeOut () {
                this.timeout = setTimeout(() => {
                    this.success = false;
                },2000);
            },
            getDivision() {
                axios.get('/api/users/create/loadDivision',{
                    params: {
                        id: this.id
                    }
                })
                .then(response => {
                    this.division = response.data.data;
                    // this.division_name = this.division[0].name;
                    // this.division_id = this.division[0].id;
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
            getUsers() {
                axios.get('/api/users/create/loadUser')
                .then(response => {
                    this.listUsers = response.data.data;
                })
                .catch(error => {
                    console.log(error);
                });
            },     
            submit() {
                axios.put('/api/users/create/'+this.form.user_id,{
                    'division_id': this.division[0].id,
                    'position_id': this.form.position_id,
                    'user_id': this.form.user_id // bat loi validation
                })
                .then(response => {
                    this.form.user_id = '',
                    this.form.position_id = '',
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

                // for(var pair of data.entries()) {
                //     console.log(pair[0] + ': ' + pair[1]);
                // }
            }
        },
    }
</script>

<style>

</style>
