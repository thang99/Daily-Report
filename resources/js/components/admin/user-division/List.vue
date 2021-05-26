<template>
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb iq-bg-primary">
                    <li class="breadcrumb-item"><a href="/home"><i class="ri-home-4-line mr-1 float-left"></i>Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User-Division</li>
                </ol>
            </nav>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">User-Division Table</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div id="table" class="table-editable">
                        <div class="float-left mb-3 mr-2">
                            <select class="form-control mb-3" @change="onChangeDivision($event)">
                                <option value="all">All</option>
                                <option v-for="division in listDivision" :key="division.id" :value="division.id">{{division.name}}</option>
                            </select>
                        </div>
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
                                    <th>Status</th>
                                    <th>Date start
                                        <span class="table-up"><a href="#!" v-if="currentSortDir == 'asc'" class="indigo-text" @click="sort('created_at')">
                                            <i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a></span>
                                        <span class="table-down"><a href="#!" v-if="currentSortDir == 'desc'" class="indigo-text" @click="sort('created_at')">
                                            <i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a></span>
                                    </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <tr v-for="user in sortListUser" :key="user.id">
                                    <td>{{user.id}}</td>
                                    <td>{{ user.name}}</td>
                                    <td>{{ user.email}}</td>
                                    <td v-if="user.status == 1">Active</td>
                                    <td v-if="user.status == 0">Disable</td>
                                    <td>{{ user.created_at| formatDate}}</td>
                                    <td> <span><button @click.prevent="deleteUser(user.id)"
                                                class="btn bg-danger-light btn-rounded btn-sm my-0">Remove</button></span></td>
                                </tr>
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example" v-if="totalPage > 1">
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
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                listUser: [],
                listDivision: [],
                totalPage : 0,
                per_page : 5,
                showPaginate :true,
                search : 'all',
                currentSort:'id',
                currentSortDir:'desc',
            }
        },
        props: {
            id_user: {
                type: Number
            },
        },
        mounted () {
            this.selectTotalPage();
            this.clickCallBack();
            axios.get('/api/admin/divisions-all')
                .then((response) => {
                    this.listDivision = response.data.data;
                })
                .catch((error) => {
                     console.log(error);
                });
        },
        methods: {
            selectTotalPage: function() {
                axios.get('/api/admin/users')
                .then((response) => {
                    this.totalPage = response.data.last_page;
                });
            },
            clickCallBack: function(pageNum = 1) {
                axios.get(`/api/admin/user-division/${this.search}?per_page=${this.per_page}&page=${pageNum}`)
                .then((response) => {
                    this.listUser = response.data.data;
                })
                .catch((error) => {
                     console.log(error);
                });
            },
            onChangeDivision: function(event,pageNum = 1) {
                // const ;
                 axios.get(`/api/admin/user-division/${event.target.value}?per_page=${this.per_page}&page=${pageNum}`)
                .then((response) => {
                    this.listUser = response.data.data;
                    this.totalPage = response.data.last_page;
                    if(this.listUser.length == 0)
                    {
                        this.showPaginate = false;
                    }
                    this.showPaginate = true;
                    this.search = event.target.value;
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
                        this.clickCallBack();
                        this.selectTotalPage();
                    });
                }
            },
            sort: function(s) {
                //if s == current sort, reverse
                if(s === this.currentSort) {
                this.currentSortDir = this.currentSortDir === 'desc' ? 'asc' : 'desc';
                } else {
                    this.currentSortDir = this.currentSortDir === 'asc' ? 'desc' : 'asc';
                }
                this.currentSort = s;
            }
        },
        computed:{
            sortListUser:function() {
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