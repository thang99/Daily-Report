<template>
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb iq-bg-primary">
                    <li class="breadcrumb-item"><a href="/home"><i class="ri-home-4-line mr-1 float-left"></i>Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Positions</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6">
            <div class="alert alert-danger" role="alert" v-if="error != ''">
                <div class="iq-alert-text">{{error}}</div>
            </div>
            <div class="alert text-white bg-success" role="alert" v-show="showNotiDelete">
                <div class="iq-alert-text">Delete a position success</div>
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
                            <h4 class="card-title">Positions Table</h4>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <span class="float-right mb-3 mr-2">
                            <button class="btn btn-sm bg-primary" data-toggle="modal" data-target="#createPositionModal"><i class="ri-add-fill">
                            <span class="pl-1">Add New</span></i>
                            </button>
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
                                <button class="btn btn-primary" @click="searchPosition()">Search</button>
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
                                    <th>Status</th>
                                    <th>Created at
                                         <span class="table-up"><a href="#!" v-if="currentSortDir == 'asc'" class="indigo-text" @click="sort('created_at')">
                                            <i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a></span>
                                        <span class="table-down"><a href="#!" v-if="currentSortDir == 'desc'" class="indigo-text" @click="sort('created_at')">
                                            <i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a></span>
                                    </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="position in sortListPosition" :key="position.id">
                                    <td>{{position.id}}</td>
                                    <td contenteditable="true">{{ position.name}}</td>
                                    <td v-if="position.status == 1">Active</td>
                                    <td v-if="position.status == 0">Disable</td>
                                    <td>{{ position.created_at | formatDate}}</td>
                                    <td>
                                        <span><button data-toggle="modal" @click="editModal(position)"
                                                class="btn bg-warning-light btn-rounded btn-sm my-0">Edit</button></span>
                                        <span><button @click.prevent="deletePosition(position.id)"
                                                class="btn bg-danger-light btn-rounded btn-sm my-0">Remove</button></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example" v-if="!checkPaginateSearch">
                            <paginate
                                v-model="numberPage"
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
                                :click-handler="searchPosition"
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
                                <h2 class="mb-0 mt-4">Oops! There are no position.</h2>
                                <p>You can add division.</p>
                            </div>
                        </div>
                    </div>
                     <div class="row" v-else-if="showNotFound">
                        <div class="col-md-12  iq-error position-relative mt-2" >
                            <div class="inner-shadow p-4 shadow-showcase text-center">
                                <h2 class="mb-0 mt-4">Oops! Not found position.</h2>
                                <p>You can check condition.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Create v-on:CreatedPosition="updateListPosition"></Create>
        <Edit :detail_position="position"></Edit>
    </div>
</template>

<script>
    import Create from './Create.vue'
    import Edit from './Edit.vue'
    export default {
        components: {
            Create,Edit
        },
        data() {
            return {
                formData: {
                    keySearch : '',
                    startDate : '',
                    endDate : '',
                },
                listPosition: [],
                totalPage : 0,
                per_page : 5,
                position : {},
                currentSort:'id',
                currentSortDir:'desc',
                checkPaginateSearch: false,
                numberPage : 1,
                numberPageSearch : 1,
                showListEmpty: false,
                showNotFound: false,
                allPosition : [],
                showNotiDelete : false,
                error : '',
            }
        },
        created () {
            this.selectTotalPage();
            this.clickCallBack();
            this.getAllPosition();
        },
        methods: {
            setTimeOut () {
                this.timeout = setTimeout(() => {
                    this.error = '';
                    this.showNotiDelete = false;
                },3000);
            },
            selectTotalPage: function() {
                axios.get('/api/admin/positions')
                .then((response) => {
                    this.totalPage = response.data.last_page;
                });
            },
            clickCallBack: function(pageNum = this.numberPage) {
                axios.get(`/api/admin/positions?per_page=${this.per_page}&page=${pageNum}`)
                .then((response) => {
                    this.numberPage = pageNum;
                    this.listPosition = response.data.data;
                })
                .catch((error) => {
                     console.log(error);
                });
            },
            editModal(position) {
                $('#editPositionModal').modal('show');
                this.position = position;
            },
            deletePosition(id) {
                if(confirm(`"Do you really want to delete postion:${id}?"`)){
                    axios.delete(`/api/admin/positions/${id}`).then(response => {
                        if(!this.formData.keySearch || !this.formData.startDate || !this.formData.endDate){
                            this.searchPosition(this.numberPageSearch);
                            if(this.listPosition.length == 1) {
                                if(this.numberPageSearch > 1){
                                    this.numberPageSearch--;
                                    this.numberPageSearch = this.numberPageSearch;
                                }
                                this.searchPosition(this.numberPageSearch);
                            }
                        }
                        else 
                        {
                            this.clickCallBack(this.numberPage);
                            if(this.listPosition.length == 1) {
                                if(this.numberPage > 1){
                                    this.numberPage--;
                                    this.numberPage = this.numberPage;
                                }
                                this.clickCallBack(this.numberPage);
                                this.getAllPosition();
                            }
                        }
                        this.showNotiDelete = true;
                        this.setTimeOut();
                    })
                    .catch((errors) => {
                        this.error = errors.response.data.error;
                        this.setTimeOut();
                    });
                }
            },
            updateListPosition() {
                this.clickCallBack(1);
                this.selectTotalPage();
                this.getAllPosition();
                this.resetFormData();
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
            searchPosition: function(pageNum = 1) {
                axios.post(`/api/admin/positions-search?per_page=${this.per_page}&page=${pageNum}`,this.formData)
                .then((response) => {
                    this.checkPaginateSearch = true;
                    this.listPosition = response.data.data;
                    this.totalPage = response.data.last_page;
                    this.numberPageSearch = pageNum;
                    this.getAllPosition();
                    if(this.allPosition.length > 0) {
                        if(this.listPosition == 0) {
                            this.showListEmpty = false;
                            this.showNotFound = true;
                        }
                        else
                        {
                            this.showListEmpty = false;
                            this.showNotFound = false;
                        }
                    }
                    if(this.allPosition.length == 0) {
                        this.showListEmpty = true;
                        this.showNotFound = false;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
            }, 
            getAllPosition: function () {
                axios.get(`/api/admin/positions-all-no-paginate`)
                .then((response) => {
                    this.allPosition = response.data.data;
                    if(this.allPosition.length == 0)
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
            resetFormData() {
                this.formData.keySearch = '';
                this.formData.startDate = '';
                this.formData.endDate = '';
            },
            
        },
        computed:{
            sortListPosition:function() {
                return this.listPosition.sort((a,b) => {
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