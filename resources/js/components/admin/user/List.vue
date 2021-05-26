<template>
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb iq-bg-primary">
                    <li class="breadcrumb-item"><a href="/home"><i class="ri-home-4-line mr-1 float-left"></i>Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6">
            <div class="alert text-white bg-success" role="alert" v-show="showNotiDelete">
                <div class="iq-alert-text">Delete a user success</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ri-close-line"></i>
                </button>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="col-md-6">
                        <div class="header-title">
                            <h4 class="card-title">Users Table</h4>
                        </div>
                    </div>
                     <div class="col-md-6">
                        <span class="float-right mb-3 mr-2">
                            <a class="btn btn-sm bg-primary" href="/admin/manager-users/create"><i class="ri-add-fill">
                            <span class="pl-1">Add New</span></i>
                            </a>
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-md-2">
                            <div class="form-group mb-0">
                                <input type="text" class="form-control todo-search" v-model="formData.keySearch"  placeholder="Search">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">From:</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control"  id="startDateReport" name="startDate" v-model="formData.startDate">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">To:</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control"  id="endDateReport" name="endDate" v-model="formData.endDate">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-0">
                                <button class="btn btn-primary" @click="searchUser()">Search</button>
                            </div>
                        </div>
                    </div>
                    <div id="table" class="table-editable" v-if="!showListEmpty && !showNotFound">
                        <table class="table table-bordered table-responsive-md table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Id
                                         <span class="table-up"><a href="#!" v-if="currentSortDir == 'asc'" class="indigo-text" @click="sort('id')">
                                            <i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a></span>
                                        <span class="table-down"><a href="#!" v-if="currentSortDir == 'desc'" class="indigo-text" @click="sort('id')">
                                            <i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a></span>
                                    </th>
                                    <th>Name
                                         <span class="table-up"><a href="#!" v-if="currentSortDir == 'asc'" class="indigo-text" @click="sort('name')">
                                            <i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a></span>
                                        <span class="table-down"><a href="#!" v-if="currentSortDir == 'desc'" class="indigo-text" @click="sort('name')">
                                            <i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a></span>
                                    </th>
                                    <th>Email
                                         <span class="table-up"><a href="#!" v-if="currentSortDir == 'asc'" class="indigo-text" @click="sort('email')">
                                            <i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a></span>
                                        <span class="table-down"><a href="#!" v-if="currentSortDir == 'desc'" class="indigo-text" @click="sort('email')">
                                            <i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a></span>
                                    </th>
                                    <th>Division</th>
                                    <th>Position</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in sortListUser" :key="user.id">
                                    <td>{{user.id}}</td>
                                    <td>{{ user.name}}</td>
                                    <td>{{ user.email}}</td>
                                    <td>{{ user.name_div}}</td>
                                    <td>{{ user.name_pos}}</td>
                                    <!-- <td><span v-for="role in user.roles" :key="role.id">{{role.name}},</span></td> -->
                                    <td v-if="user.status == 1">Active</td>
                                    <td v-if="user.status == 0">Disable</td>
                                    <td>{{ user.created_at | formatDate}}</td>
                                    <td>
                                        <span><a class="btn bg-warning-light btn-rounded btn-sm my-0" :href="`/admin/manager-users/${user.id}`">
                                                Edit </a></span>
                                        <!-- <span><button data-toggle="modal" class="btn bg-warning-info btn-primary btn-sm my-0" @click="changePassModal(user)">
                                                Change Pass</button></span> -->
                                        <span><button @click.prevent="deleteUser(user.id)"
                                                class="btn bg-danger-light btn-rounded btn-sm my-0">Remove</button></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example" v-if="!checkPaginateSearch">
                            <paginate
                                :page-count="totalPage"
                                :page-range="3"
                                :margin-pages="2"
                                :click-handler="clickCallBack"
                                :prev-text="'Prev'"
                                :next-text="'Next'"
                                :container-class="'pagination justify-content-center'"
                                :page-class="'page-item'"
                                :page-link-class="'page-link'"
                                :prev-class="'page-item'"
                                :prev-link-class="'page-link'"
                                :next-class="'page-item'"
                                :next-link-class="'page-link'">
                            </paginate>
                        </nav> 
                        <nav aria-label="Page navigation example" v-if="checkPaginateSearch">
                            <paginate
                                v-model="numberPageSearch"
                                :page-count="totalPage"
                                :page-range="3"
                                :margin-pages="2"
                                :click-handler="searchUser"
                                :prev-text="'Prev'"
                                :next-text="'Next'"
                                :container-class="'pagination justify-content-center'"
                                :page-class="'page-item'"
                                :page-link-class="'page-link'"
                                :prev-class="'page-item'"
                                :prev-link-class="'page-link'"
                                :next-class="'page-item'"
                                :next-link-class="'page-link'">
                            </paginate>
                        </nav>
                    </div>
                    <div class="row" v-else-if="showListEmpty && !showNotFound">
                        <div class="col-md-12  iq-error position-relative mt-2" >
                            <div class="inner-shadow p-4 shadow-showcase text-center">
                                <h2 class="mb-0 mt-4">Oops! There are no divisions.</h2>
                                <p>You can add division.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else-if="showNotFound">
                        <div class="col-md-12  iq-error position-relative mt-2" >
                            <div class="inner-shadow p-4 shadow-showcase text-center">
                                <h2 class="mb-0 mt-4">Oops! Not found division.</h2>
                                <p>You can check condition.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <ChangePass :detail_user="user"></ChangePass>
    </div>
</template>

<script>
    import ChangePass from './ChangePass.vue'
    export default {
         components: {
            ChangePass
        },
        props: {
            id_user: {
                type: Number
            },
        },
        data() {
            return {
                formData: {
                    keySearch : '',
                    startDate : '',
                    endDate : '',
                },
                listUser: [],
                totalPage : 0,
                per_page : 5,
                user: {},
                currentSort:'id',
                currentSortDir:'desc',
                checkPaginateSearch: false,
                numberPage : 1,
                numberPageSearch : 1,
                showListEmpty: false,
                showNotFound: false,
                allPosition : [],
                showNotiDelete : false,
                allUser : [],
                showNotiDelete : false,
            }
        },
        mounted () {
            this.selectTotalPage();
            this.clickCallBack();
            this.getAllUser();
        },
        methods: {
            setTimeOut () {
                this.timeout = setTimeout(() => {
                    this.error = '';
                    this.showNotiDelete = false;
                },3000);
            },
            selectTotalPage: function() {
                axios.get('/api/admin/users')
                .then((response) => {
                    this.totalPage = response.data.last_page;
                });
            },
            clickCallBack: function(pageNum = this.numberPage) {
                axios.get(`/api/admin/users?per_page=${this.per_page}&page=${pageNum}`)
                .then((response) => {
                this.listUser = response.data.data;
                this.numberPage  = pageNum;
                })
                .catch((error) => {
                    console.log(error);
                });
            },
            deleteUser: function(id) {
                if(confirm(`"Do you really want to delete user:${id}?"`)){
                    if(id == this.id_user){
                        alert('You can\'t account loggin');
                        return false;
                    }
                    axios.delete(`/api/admin/users/${id}`).then(response => {
                        if(!this.formData.keySearch || !this.formData.startDate || !this.formData.endDate){
                            this.searchUser(this.numberPageSearch);
                            if(this.listUser.length == 1) {
                                if(this.numberPageSearch > 1){
                                    this.numberPageSearch--;
                                    this.numberPageSearch = this.numberPageSearch;
                                }
                                this.searchUser(this.numberPageSearch);
                            }
                        } else {
                            this.clickCallBack(this.numberPage);
                            if(this.listUser.length == 1) {
                                if(this.numberPage > 1){
                                    this.numberPage--;
                                    this.numberPage = this.numberPage;
                                }
                                this.clickCallBack(this.numberPage);
                                this.getAllDivision();
                            }
                        }
                        this.showNotiDelete = true;
                        this.setTimeOut();
                    });
                }
            },
            changePassModal(user) {
                $('#changePassModal').modal('show');
                this.user = user;
            },
            sort: function(s) {
                //if s == current sort, reverse
                if(s === this.currentSort) {
                this.currentSortDir = this.currentSortDir === 'desc' ? 'asc' : 'desc';
                } else {
                    this.currentSortDir = this.currentSortDir === 'asc' ? 'desc' : 'asc';
                }
                this.currentSort = s;
            },
            searchUser: function(pageNum = 1) {
                axios.post(`/api/admin/user-search-paginate?per_page=${this.per_page}&page=${pageNum}`,this.formData)
                .then((response) => {
                    this.checkPaginateSearch = true;
                    this.listUser = response.data.data;
                    this.totalPage = response.data.last_page;
                    this.numberPageSearch = pageNum;
                    this.getAllUser();
                    if(this.allUser.length > 0) {
                        if(this.listUser == 0) {
                            this.listUser = false;
                            this.showNotFound = true;
                        }
                        else
                        {
                            this.showListEmpty = false;
                            this.showNotFound = false;
                        }
                    }
                    if(this.allUser.length == 0) {
                        this.showListEmpty = true;
                        this.showNotFound = false;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
            },
            getAllUser: function () {
                axios.get(`/api/admin/user-all`)
                .then((response) => {
                    this.allUser = response.data.data;
                    if(this.allUser.length == 0)
                    {
                        this.showListEmpty = true;
                    }
                    else {
                        this.showListEmpty = false;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
            },
        },
         computed:{
            sortListUser: function() {
                return this.listUser.sort((a,b) => {
                    let modifier = -1;
                    if(this.currentSortDir === 'asc') modifier = 1;
                    if(a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
                    if(a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
                    return 0;
                });
            }
        }
        
    }
</script>

<style >

</style>