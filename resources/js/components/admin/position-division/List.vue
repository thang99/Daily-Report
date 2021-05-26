<template>
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb iq-bg-primary">
                    <li class="breadcrumb-item"><a href="/home"><i class="ri-home-4-line mr-1 float-left"></i>Home</a></li>
                    <li class="breadcrumb-item"><a href="/admin/divisions">Divisions</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Position</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6">
            <div class="alert alert-danger" role="alert" v-show="showError">
                <div class="iq-alert-text">{{error}}</div>
            </div>
            <div class="alert text-white bg-success" role="alert" v-show="success">
                <div class="iq-alert-text">Delete a position success</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ri-close-line"></i>
                </button>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                        <div class="col-md-6"><span>Division : <span class="bg-primary-light pl-3 pr-3 pt-2 pb-2 rounded d-inline-block">{{this.namePosi}}</span></span></div>
                        <div class="col-md-6">
                            <span class="float-right mb-3 mr-2" v-show="typeof allPosi !== 'undefined' && allPosi.length > 0">
                                <button class="btn btn-sm bg-primary" data-toggle="modal" data-target="#addPostionModal"><i class="ri-add-fill">
                                <span class="pl-1">Add Postion To Division</span></i>
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
                                <div class="text-danger" v-if="errors && errors.startDate">
                                    {{ errors.startDate[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">To:</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control"  id="endDateReport" name="endDate" v-model="formData.endDate">
                                </div>
                                <div class="text-danger" v-if="errors && errors.endDate">
                                    {{ errors.endDate[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-0">
                                <button class="btn btn-primary" @click="searchPosition()">Search</button>
                            </div>
                        </div>
                    </div>
                  
                    <div id="table" class="table-editable" v-if="typeof allPosi !== 'undefined' && allPosi.length > 0 && typeof listPosi !== 'undefined' && listPosi.length > 0 && !showSearchNull">
                        <table  class="table table-bordered table-responsive-md table-striped text-center mt-2" >
                            <thead>
                                <tr>
                                    <th>Id
                                        <span class="table-up"><a href="#!" v-if="currentSortDir == 'asc'" class="indigo-text" @click="sort('id')">
                                            <i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a></span>
                                        <span class="table-down"><a href="#!" v-if="currentSortDir == 'desc'" class="indigo-text" @click="sort('id')">
                                            <i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a></span>
                                    </th>
                                    <th>Position
                                        <span class="table-up"><a href="#!" v-if="currentSortDir == 'asc'" class="indigo-text" @click="sort('position')">
                                            <i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a></span>
                                        <span class="table-down"><a href="#!" v-if="currentSortDir == 'desc'" class="indigo-text" @click="sort('position')">
                                            <i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a></span>
                                    </th>
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
                                    <td contenteditable="true">{{ position.name_position}}</td>
                                    <td>{{ position.created_at | formatDate}}</td>
                                    <td>
                                        <span><button @click.prevent="deletePosition(position.id)"
                                                class="btn bg-danger-light btn-rounded btn-sm my-0">Remove</button></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example" v-if="!checkPaginate" >
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
                        <nav aria-label="Page navigation example" v-if="checkPaginate">
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
                    <div class="row" v-else-if="typeof allPosi !== 'undefined' && allPosi.length == 0 && !showSearchNull">
                        <div class="col-md-12  iq-error position-relative mt-2" >
                            <div class="inner-shadow p-4 shadow-showcase text-center">
                                <h2 class="mb-0 mt-4">Oops! Division haven't postion.</h2>
                                <p>You can add postion to division.</p>
                                <a class="btn btn-primary d-inline-flex align-items-center mt-3" href="/admin/divisions">
                                <i class="ri-home-4-line"></i>Back to Division</a>
                                <span class=" mb-3 mr-2">
                                    <button class="btn btn-primary mt-3" data-toggle="modal" data-target="#addPostionModal"><i class="ri-add-fill">
                                    <span class="pl-1">Add Postion To Division</span></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else-if="showSearchNull">
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
        <Position :id_division="id_division" v-on:listPosition="updateListPosi"></Position>
    </div>
</template>

<script>
    import Position from './Position.vue'
    export default {
        components: {
            Position
        },
        data() {
            return {
                formData: {
                    keySearch : '',
                    startDate : '',
                    endDate : '',
                },
                listPosi: [],
                namePosi: '',
                totalPage : 0,
                per_page : 5,
                error : '',
                success: false,
                showError: false,
                currentSort:'id',
                currentSortDir:'desc',
                errors : '',
                numberPage : 1,
                numberPageSearch : 1,
                allPosi : [],
                checkPaginate: false,
                showSearchNull : false,
            }
        },
        props: {
            id_division: {
                type: Number,
            }
        },
        mounted () {
            this.getAllPosition();
            this.selectTotalPage();
            this.clickCallBack();
            this.getNamePosition();
            this.updateListPosi();
        },
        methods: {
            getAllPosition() {
                axios.get(`/api/admin/positions-divisions-all/${this.id_division}`)
                .then((response) => {
                    this.allPosi = response.data.data;
                })
                .catch((error) => {
                     console.log(error);
                });
            },
            setTimeOutNoti() {
                this.timeout = setTimeout(() => {
                    this.success = false;
                    this.showError = false;
                },3000);
            },
            selectTotalPage: function() {
                axios.get(`/api/admin/positions-divisions/${this.id_division}`)
                .then((response) => {
                    this.totalPage = response.data.last_page;
                });
            },
            clickCallBack: function(pageNum = this.numberPage) {
                axios.get(`/api/admin/positions-divisions/${this.id_division}?per_page=${this.per_page}&page=${pageNum}`)
                .then((response) => {
                    this.listPosi = response.data.data;
                    this.numberPage = pageNum;      
                })
                .catch((error) => {
                     console.log(error);
                });
            },
            deletePosition(id) {
                if(confirm("Do you want to remove a position from the division?")){
                        axios.delete(`/api/admin/positions-divisions/${id}`).then(response => {
                            if(!this.formData.keySearch && !this.formData.startDate && !this.formData.endDate){
                                this.selectTotalPage();
                                this.clickCallBack(this.numberPage);
                                if(this.listPosi.length == 1) {
                                    if(this.numberPage > 1){
                                        this.numberPage--;
                                        this.numberPage = this.numberPage;
                                        
                                    }
                                    this.clickCallBack(this.numberPage);
                                    this.getAllPosition();
                                }
                            } else {
                                this.searchPosition(this.numberPageSearch);
                                if(this.listPosi.length == 1) {
                                    if(this.numberPageSearch > 1){
                                        this.numberPageSearch--;
                                        this.numberPageSearch = this.numberPageSearch;
                                    }
                                    this.searchPosition(this.numberPageSearch);
                                    this.getAllPosition();
                                }
                            }
                            this.success = true;
                            this.setTimeOutNoti();
                        })
                        .catch((errors) => {
                            this.showError = true;
                            this.error = errors.response.data.error;
                            this.setTimeOutNoti();
                        });
                }
            },
            updateListPosi(value) {
                this.listPosi = value;
                this.selectTotalPage();
                this.numberPage = 1;
                this.clickCallBack(this.numberPage);
                this.getAllPosition();
                this.checkPaginate = false;
                this.resetFormData();
            },
            getNamePosition() {
                axios.get(`/api/admin/divisions/`+this.id_division)
                .then((response) => {
                    this.namePosi = response.data.data.name;
                })
                .catch((error) => {
                     console.log(error);
                });
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
                axios.post(`/api/admin/positions-divisions-search/${this.id_division}?per_page=${this.per_page}&page=${pageNum}`,this.formData)
                .then((response) => {
                    this.checkPaginate = true;
                    this.listPosi = response.data.data;
                    this.totalPage = response.data.last_page;
                    this.numberPageSearch = pageNum;
                    if(this.allPosi.length == 0) {
                         this.showSearchNull = false;
                    } else {
                        this.searchPositionNoPaginate();
                    }
                    
                })
                .catch((error) => {
                     console.log(error);
                });
            },
            searchPositionNoPaginate: function() {
                axios.post(`/api/admin/positions-divisions-search-all/${this.id_division}`,this.formData)
                .then((response) => {
                    let allPosition = response.data.data;
                    if(allPosition.length == 0){
                        this.showSearchNull = true;
                    } else {
                        this.showSearchNull = false;
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
            }
        },
        computed:{
            sortListPosition:function() {
                return this.listPosi.sort((a,b) => {
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