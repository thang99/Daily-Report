<template>
 <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">User Table</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group d-flex">
                        <input type="text" class="form-control w-25 mr-5" v-model="searchQuery" placeholder="Search by name">
                        <button type="button" class="btn btn-success search" @click="searchUserByName()">Search</button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="success">
                        <div class="iq-alert-text">Remove user success</div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="table" class="table-editable mt-5">
                        <span class="float-right mb-3 mr-2">
                            <a class="btn btn-sm bg-primary" href="/manager/users/create"><i class="ri-add-fill">
                                <span class="pl-1">Add New</span></i>
                            </a>
                        </span>
                        <table class="table table-bordered table-responsive-md table-striped text-center">
                            <thead>
                                <tr>
                                    <th>#
                                        <span class="table-up"><a href="#!" v-if="currentSortDir == 'asc'" class="indigo-text" @click="sort('id')">
                                            <i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a>
                                        </span>
                                        <span class="table-down"><a href="#!" v-if="currentSortDir == 'desc'" class="indigo-text" @click="sort('id')">
                                            <i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a>
                                        </span>
                                    </th>
                                    <th>Name
                                        <span class="table-up"><a href="#!" v-if="currentSortDir == 'asc'" class="indigo-text" @click="sort('name')">
                                            <i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a>
                                        </span>
                                        <span class="table-down"><a href="#!" v-if="currentSortDir == 'desc'" class="indigo-text" @click="sort('name')">
                                            <i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a>
                                        </span>
                                    </th>
                                    <th>Position
                                        <span class="table-up"><a href="#!" v-if="currentSortDir == 'asc'" class="indigo-text" @click="sort('position_name')">
                                            <i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a>
                                        </span>
                                        <span class="table-down"><a href="#!" v-if="currentSortDir == 'desc'" class="indigo-text" @click="sort('position_name')">
                                            <i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a>
                                        </span>
                                    </th>
                                    <th>Avatar</th>
                                    <th>Email
                                        <span class="table-up"><a href="#!" v-if="currentSortDir == 'asc'" class="indigo-text" @click="sort('email')">
                                            <i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a>
                                        </span>
                                        <span class="table-down"><a href="#!" v-if="currentSortDir == 'desc'" class="indigo-text" @click="sort('email')">
                                            <i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a>
                                        </span>
                                    </th>
                                    <th>Phone</th>
                                    <th>Birthday
                                        <span class="table-up"><a href="#!" v-if="currentSortDir == 'asc'" class="indigo-text" @click="sort('birthday')">
                                            <i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a>
                                        </span>
                                        <span class="table-down"><a href="#!" v-if="currentSortDir == 'desc'" class="indigo-text" @click="sort('birthday')">
                                            <i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a>
                                        </span>
                                    </th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody v-if="this.listUsers.length > 0">
                                <tr v-for="user in sortListUser" :key="user.id">
                                    <td>{{ user.id }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.position_name }}</td>
                                    <td><img :src="'/images/users/'+user.avatar" alt="avatar" width="60" height="50"></td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.phone }}</td>
                                    <td>{{ user.birthday }}</td>  
                                    <td>
                                         <span><a class="btn bg-warning-light btn-rounded btn-sm my-0" :href="'users/'+user.id+'/edit'">
                                                Edit </a></span>
                                        <span><button @click.prevent="removeUser(user.id)"
                                                class="btn bg-danger-light btn-rounded btn-sm my-0">Remove</button></span>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="8">
                                        <div class="alert alert-danger justify-content-center" role="alert">
                                            Not found !!!
                                        </div>
                                    </td>  
                                </tr>
                            </tbody>
                        </table>
                        <div v-if="this.listUsers.length > 0 && !this.searchQuery">
                            <nav aria-label="Page navigation example">
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
                        <div v-if="this.listUsers.length > 0 && this.searchQuery">
                            <nav aria-label="Page navigation example">
                                <paginate
                                    :page-count="totalPage"
                                    :page-range="3"
                                    :margin-pages="2"
                                    :click-handler="searchUserByName"
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
    </div>
</template>

<script>
export default {
    props: ['id'],
    data() {
        return {
            listUsers : [],
            searchQuery: '',
            totalPage : 0,
            per_page : 5,
            pageNum : 1,
            currentSort:'id',
            currentSortDir:'desc',
            success : false,
            timeout : null,
            pageNumber: null
        }
    },
    mounted () {
        this.selectTotalPage();
        this.clickCallBack();
    },
    methods: {
        setTimeOut () {
            this.timeout = setTimeout(() => {
                this.success = false;
            },2000);
        },
        selectTotalPage: function() {
            axios.get(`/api/users/`,{
                params: {
                    id: this.id
                }
            })
            .then((response) => {
                this.totalPage = response.data.last_page;
            });
        },
        clickCallBack: function (pageNum = 1) {
            axios.get(`/api/users?per_page=${this.per_page}&page=${pageNum}`,{
                params : {
                    id: this.id
                }
            })
            .then((response) => {
                this.listUsers = response.data.data;
                this.pageNumber = pageNum;
            })
            .catch((error) => {
                console.log(error);
            });
        },
        searchUserByName(pageNum = 1) {
            if(this.searchQuery) {
                axios.post(`/api/users/search?per_page=${this.per_page}&page=${pageNum}`,{
                    keyword : this.searchQuery,
                    id: this.id
                })
                .then((response) => {
                    this.listUsers = response.data.data;
                    this.totalPage = response.data.last_page;
                })
                .catch(error => {
                    console.log(error);
                })
            } else{
                this.selectTotalPage();
                this.clickCallBack();
            }   
        },
        removeUser(id) {
            if(confirm(`"Do you want to remove user :${id}?"`)){
                axios.put('/api/users/remove/'+id)
                .then(response => {
                    this.selectTotalPage();
                    if(this.listUsers.length == 1) {
                        this.clickCallBack(this.pageNumber-1);
                    } else {
                        this.clickCallBack(this.pageNumber);
                    }
                    this.success = true;
                    this.setTimeOut();
                })
                .catch(error => {
                    console.log(error);
                });
            }
        },
        sort(s) {
            //if s == current sort, reverse
            if(s === this.currentSort) {
                this.currentSortDir = this.currentSortDir === 'desc' ? 'asc' : 'desc';
            } else {
                this.currentSortDir = this.currentSortDir === 'asc' ? 'desc' : 'asc';
            }
            this.currentSort = s;
        },
    },
    computed: {
        sortListUser() {
            return this.listUsers.sort((a,b) => {
                let modifier = -1;
                if(this.currentSortDir === 'asc') modifier = 1;
                if(a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
                if(a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
                return 0;
            });
        }
    },
}
</script>

<style scoped>
.search {
    height: 38px;
}
input[type='text'] {
    height: 38px;
}
</style>