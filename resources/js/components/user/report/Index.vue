<template>
    <div class="row">
        <div class="col-sm-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My report</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Report Table</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for=""> From:</label>
                                <input type="date" class="form-control" v-model="startDate" id="startDateReport" name="start_date">
                                <div class="text-danger" v-if="errors && errors.start_date">
                                    {{ errors.start_date[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">To:</label>
                                <input type="date" class="form-control" v-model="endDate" id="endDateReport" name="end_date">
                                <div class="text-danger" v-if="errors && errors.end_date">
                                    {{ errors.end_date[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Search by title:</label>
                                <input type="text" class="form-control w-100 mr-5" v-model="searchKey" placeholder="Title ...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-success" style="margin-top:34px" @click="searchReport()">Search</button>
                        </div>
                    </div>
                    <div id="table" class="table-editable">
                        <span class="float-right mb-3 mr-2">
                            <button class="btn btn-sm bg-primary" data-toggle="modal"
                                    data-target="#createReportModal"><i class="ri-add-fill">
                            <span class="pl-1">Add New</span></i>
                            </button>
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
                                    <th>Title
                                        <span class="table-up"><a href="#!" v-if="currentSortDir == 'asc'" class="indigo-text" @click="sort('title')">
                                            <i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a>
                                        </span>
                                        <span class="table-down"><a href="#!" v-if="currentSortDir == 'desc'" class="indigo-text" @click="sort('title')">
                                            <i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a>
                                        </span>
                                    </th>
                                    <th style="width:500px">Content</th>
                                    <th>Assign to</th>
                                    <th>Status</th>
                                    <th>Created at
                                        <span class="table-up"><a href="#!" v-if="currentSortDir == 'asc'" class="indigo-text" @click="sort('created_at')">
                                            <i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a>
                                        </span>
                                        <span class="table-down"><a href="#!" v-if="currentSortDir == 'desc'" class="indigo-text" @click="sort('created_at')">
                                            <i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a>
                                        </span>
                                    </th>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody v-if="this.listReport.length >0">
                                <tr v-for="report in sortListReport" :key="report.id">
                                    <td>{{ report.id }}</td>
                                    <td>{{ report.title }}</td>
                                    <td style="width:500px">
                                        <span :title="report.content">{{ report.content | truncate(20, '...') }}</span>
                                    </td>
                                    <td>{{ report.assign_user[0].name }}</td>
                                    <td v-if="report.status == 0">
                                        <button class="btn btn-primary btn-sm">Pending</button>
                                    </td>
                                    <td v-else-if="report.status == -1">
                                        <button class="btn btn-danger btn-sm">Refuse</button>
                                    </td>
                                    <td v-else>
                                        <button class="btn btn-success btn-sm">Accept</button>
                                    </td>
                                    <td>{{ report.created_at | formatDate }}</td>
                                    <td style="width:120px">
                                        <span>
                                            <a :href="report.id" role="button" class="btn btn-secondary btn-sm">Show detail</a>
                                        </span>
                                    </td>
                                    <td v-if="report.status == 0">
                                        <span>
                                            <a :href="report.id+'/edit'" role="button" class="btn btn-warning btn-sm">Edit</a>
                                        </span>
                                        <!-- <span>
                                            <button @click.prevent="deleteReport(report.id)"
                                                class="btn bg-danger-light btn-rounded btn-sm my-0">Remove
                                            </button>
                                        </span> -->
                                    </td>
                                    <td v-else>
                                        <!-- <span>
                                            <a href="#" role="button" class="btn btn-warning btn-sm" disabled>Edit</a>
                                        </span> -->
                                        <!-- <span>
                                            <button @click.prevent="deleteReport(report.id)"
                                                class="btn bg-danger-light btn-rounded btn-sm my-0">Remove
                                            </button>
                                        </span> -->
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="7">
                                        <div class="alert alert-danger justify-content-center" role="alert">
                                            Not found report !!!
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-if="this.listReport.length > 0 && !this.searchKey && !this.startDate && !this.endDate">
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
                        <div v-if="this.listReport.length > 0 && this.searchKey && this.endDate && this.startDate">
                            <nav aria-label="Page navigation example">
                                <paginate
                                    :page-count="totalPage"
                                    :page-range="3"
                                    :margin-pages="2"
                                    :click-handler="searchReport"
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
                        <div v-if="this.listReport.length > 0 && !this.searchKey && this.endDate && this.startDate">
                            <nav aria-label="Page navigation example">
                                <paginate
                                    :page-count="totalPage"
                                    :page-range="3"
                                    :margin-pages="2"
                                    :click-handler="searchReport"
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
                        <div v-if="this.listReport.length > 0 && this.searchKey && this.endDate && this.startDate">
                            <nav aria-label="Page navigation example">
                                <paginate
                                    :page-count="totalPage"
                                    :page-range="3"
                                    :margin-pages="2"
                                    :click-handler="searchReport"
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

        <form-create-report-component :userId="id" v-on:CreatedReport="updateListReport"></form-create-report-component>

    </div>
</template>

<script>
import Create from './Create.vue';

export default {
    name: "Index",
    components : { Create },
    props: ['id'],
    data() {
        return {
            listReport: [],
            report: '',
            totalPage: 0,
            per_page: 5,
            pageNum: 1,
            searchKey: '',
            startDate: '',
            endDate: '',
            errors: {},
            currentSort:'id',
            currentSortDir:'desc',
        }
    },
    filters: {
        truncate: function (text, length, suffix) {
            if (text.length > length) {
                return text.substring(0, length) + suffix;
            } else {
                return text;
            }
        },
    },
    mounted() {
        this.selectTotalPage();
        this.clickCallBack();
    },
    methods: {
        selectTotalPage: function () {
            axios.get('/api/user-reports/list', {
                params: {
                    id: this.id
                }
            })
            .then((response) => {
                this.totalPage = response.data.last_page;
            });
        },
        clickCallBack: function (pageNum = 1) {
            axios.get(`/api/user-reports/list?per_page=${this.per_page}&page=${pageNum}`, {
                params: {
                    id: this.id
                }
            })
            .then(response => {
                this.listReport = response.data.data;
            })
            .catch(error => {
                console.log(error);
            });
        },
        updateListReport() {
            this.selectTotalPage();
            this.clickCallBack();
        },
        searchReport(pageNum = 1) {
            if(this.searchKey && !this.startDate && !this.endDate) {
                axios.post(`/api/user-reports/searchByTitle?per_page=${this.per_page}&page=${pageNum}`,{
                    keyword : this.searchKey,
                    id: this.id
                })
                .then((response) => {
                    this.listReport = response.data.data;
                    this.totalPage = response.data.last_page;
                })
                .catch(errors => {
                    if (errors && errors.response.status == 422) {
                        this.errors = errors.response.data.errors;
                    }
                })
            } else if (this.startDate && this.endDate && !this.searchKey) {
                axios.post(`/api/user-reports/filterByDate?per_page=${this.per_page}&page=${pageNum}`,{
                    id: this.id,
                    start_date: this.startDate,
                    end_date: this.endDate
                })
                .then(response => {
                    this.listReport = response.data.data;
                    this.totalPage = response.data.last_page;
                })
                .catch(errors => {
                    if (errors && errors.response.status == 422) {
                        this.errors = errors.response.data.errors;
                    }
                })
            } else if (this.startDate && this.endDate && this.searchKey) {
                axios.post(`/api/user-reports/searchByTitleAndDate?per_page=${this.per_page}&page=${pageNum}`,{
                    id: this.id,
                    keyword : this.searchKey,
                    start_date: this.startDate,
                    end_date: this.endDate
                })
                .then(response => {
                    this.listReport = response.data.data;
                    this.totalPage = response.data.last_page;
                })
                .catch(errors => {
                    if (errors && errors.response.status == 422) {
                        this.errors = errors.response.data.errors;
                    }
                })
            } else {
                this.selectTotalPage();
                this.clickCallBack();
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
        // deleteReport(id) {
        //     if(confirm(`"Do you want to delete report:${id}?"`)){
        //         axios.delete(`/api/user-reports/list/${id}`)
        //         .then(response => {
        //             this.selectTotalPage();
        //             this.clickCallBack();
        //         })
        //         .catch(error => {
        //             console.log(error);
        //         });
        //     }
        // },
    },
    computed:{
        sortListReport:function() {
            return this.listReport.sort((a,b) => {
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

<style scoped>
    input[type="text"] {
        height: 40px;
        line-height: 40px;
    }
</style>
