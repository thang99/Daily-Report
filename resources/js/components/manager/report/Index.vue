<template>
    <div class="row">
        <div class="col-sm-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manager Report</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Report Table</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-content-center">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="button" class="btn btn-success ml-5" @click="search()">Search</button>
                            </div>
                        </div>
                    </div>
                    <div id="table" class="table-editable mt-5">
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
                                <th>From
                                    <span class="table-up"><a href="#!" v-if="currentSortDir == 'asc'" class="indigo-text" @click="sort('user_id')">
                                        <i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a>
                                    </span>
                                    <span class="table-down"><a href="#!" v-if="currentSortDir == 'desc'" class="indigo-text" @click="sort('user_id')">
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
                                <th style="width:400px">Content</th>
                                <th>Created at
                                    <span class="table-up"><a href="#!" v-if="currentSortDir == 'asc'" class="indigo-text" @click="sort('created_at')">
                                        <i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a>
                                    </span>
                                    <span class="table-down"><a href="#!" v-if="currentSortDir == 'desc'" class="indigo-text" @click="sort('created_at')">
                                        <i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a>
                                    </span>
                                </th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody v-if="this.listReports.length > 0">
                                <tr v-for="report in sortListReport" :key="report.id">
                                    <td>{{ report.id }}</td>
                                    <td>{{ report.user.name }}</td>
                                    <td>{{ report.title }}</td>
                                    <td style="width:400px">
                                        <span :title="report.content">{{ report.content | truncate(20, '...') }}</span>
                                    </td>
                                    <td>{{ report.created_at | formatDate }}</td>
                                    <td @click="getReportId(report.id)">
                                        <!-- <div class="form-group">
                                            <select v-if="report.status == 0" class="bg-primary form-control mb-3"
                                                    @change="changeStatus($event,report.user_id)" data-target="#myModal">
                                                <option value="0" class="btn btn-primary" selected>Pending</option>
                                                <option value="1" class="btn btn-success">Accept</option>
                                                <option value="-1" class="btn btn-danger">Refure</option>
                                            </select>
                                            <select v-else-if="report.status == -1" class="bg-danger form-control mb-3"
                                                    @change="changeStatus($event,report.user_id)" disabled>
                                                <option value="0" class="btn btn-primary">Pending</option>
                                                <option value="1" class="btn btn-success">Accept</option>
                                                <option value="-1" class="btn btn-danger" selected>Refure</option>
                                            </select>
                                            <select v-else class="bg-success form-control mb-3"
                                                    @change="changeStatus($event,report.user_id)" disabled>
                                                <option value="0" class="btn btn-primary">Pending</option>
                                                <option value="1" class="btn btn-success" selected>Accept</option>
                                                <option value="-1" class="btn btn-danger">Refure</option>
                                            </select>
                                        </div> -->
                                        <div class="form-group">
                                            <select v-if="report.status == 0" class="bg-primary form-control mb-3 select_status"
                                                    @change="showModal($event,report.user_id)" data-target="#myModal">
                                                <option value="0" class="btn btn-primary" selected>Pending</option>
                                                <option value="1" class="btn btn-success">Accept</option>
                                                <option value="-1" class="btn btn-danger">Refure</option>
                                            </select>
                                            <select v-else-if="report.status == -1" class="bg-danger form-control mb-3"
                                                    disabled>
                                                <option value="0" class="btn btn-primary">Pending</option>
                                                <option value="1" class="btn btn-success">Accept</option>
                                                <option value="-1" class="btn btn-danger" selected>Refure</option>
                                            </select>
                                            <select v-else class="bg-success form-control mb-3"
                                                    disabled>
                                                <option value="0" class="btn btn-primary">Pending</option>
                                                <option value="1" class="btn btn-success" selected>Accept</option>
                                                <option value="-1" class="btn btn-danger">Refure</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="6">
                                        <div class="alert alert-danger justify-content-center" role="alert">
                                            Not found report !!!
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-if="this.listReports.length > 0 && !this.startDate && !this.endDate">
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
                        <div v-if="this.listReports.length > 0 && this.startDate && !this.endDate">
                            <nav aria-label="Page navigation example">
                                <paginate
                                    :page-count="totalPage"
                                    :page-range="3"
                                    :margin-pages="2"
                                    :click-handler="search"
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
                        <div v-if="this.listReports.length > 0 && this.endDate && !this.startDate">
                            <nav aria-label="Page navigation example">
                                <paginate
                                    :page-count="totalPage"
                                    :page-range="3"
                                    :margin-pages="2"
                                    :click-handler="search"
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
                        <div v-if="this.listReports.length > 0 && this.startDate && this.endDate">
                            <nav aria-label="Page navigation example">
                                <paginate
                                    :page-count="totalPage"
                                    :page-range="3"
                                    :margin-pages="2"
                                    :click-handler="search"
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
        <Reason :id_manager="id" :id_user="id_user" :id_report="id_report" :option="option" :listReports.sync="listReports" :search="search"></Reason>
    </div>
</template>

<script>
import Reason from './Reason';

export default {
    props: ['id'],
    components: { Reason },
    data() {
        return {
            listReports: [],
            startDate: '',
            endDate: '',
            status: '',
            id_report: '',
            id_user: '',
            totalPage: 0,
            per_page: 5,
            pageNum: 1,
            pageNumber : null,
            currentSort:'id',
            currentSortDir:'desc',
            errors : {},
            option: '',
        }
    },
    mounted() {
        this.selectTotalPage();
        this.clickCallBack();
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
    methods: {
        selectTotalPage: function() {
            axios.get('/api/ap',{
                params: {
                    id: this.id
                }
            })
            .then((response) => {
                this.totalPage = response.data.last_page;
            });
        },
        clickCallBack: function (pageNum = this.pageNumber) {
            axios.get(`/api/reports?per_page=${this.per_page}&page=${pageNum}`,{
                 params: {
                    id: this.id
                }
            })
            .then((response) => {
                this.listReports = response.data.data;
                this.pageNumber = pageNum;
            })
            .catch((error) => {
                console.log(error);
            });
        },
        search(pageNum = 1) {
            if (this.startDate && !this.endDate) {
                axios.post(`/api/reports/filterByDay?per_page=${this.per_page}&page=${pageNum}`, {
                    id: this.id,
                    keyword: this.startDate
                })
                .then(response => {
                    this.listReports = response.data.data;
                    this.totalPage = response.data.last_page;
                    this.pageNumber = pageNum;
                })
                .catch(error => {
                    console.log(error);
                })
            } else if (!this.startDate && this.endDate) {
                axios.post(`/api/reports/filterByMonth?per_page=${this.per_page}&page=${pageNum}`, {
                    id: this.id,
                    keyword: this.endDate
                })
                .then(response => {
                    this.listReports = response.data.data;
                    this.totalPage = response.data.last_page;
                    this.pageNumber =pageNum;
                })
                .catch(error => {
                    console.log(error);
                })
            } else if (this.startDate && this.endDate) {
                axios.post(`/api/reports/filterAll?per_page=${this.per_page}&page=${pageNum}`, {
                    id: this.id,
                    keyword1: this.startDate,
                    keyword2: this.endDate
                })
                .then(response => {
                    this.listReports = response.data.data;
                    this.totalPage = response.data.last_page;
                    this.pageNumber =pageNum;
                })
                .catch(error => {
                    console.log(error);
                })
            } else {
                this.selectTotalPage();
                this.clickCallBack();
            }
        },
        getReportId(id) {
            this.id_report = id;
        },
        // changeData(user_id) {
        //     this.id_user = user_id;
        //     axios.patch('/api/reports/' + this.id_report, {
        //         status: this.status,
        //         user_report_id: user_id,
        //         user_feedback_id: this.id,
        //     })
        //     .then(response => {
        //         this.listReports = response.data.data;
        //         this.search();
        //     })
        //     .catch(error => {
        //         console.log(error);
        //     });
        // },
        // changeStatus(e, user_id) {
        //     console.log(user_id)
        //     if (e.target.options.selectedIndex > -1) {
        //         let option = e.target.options[e.target.options.selectedIndex].value;
        //         console.log(e.target.selectedIndex);
        //         if (option == 1) {
        //             this.status = 1;
        //             this.changeData(user_id);
        //         } else if (option == 0) {
        //             this.status = 0;
        //             this.changeData(user_id);
        //         } else {
        //             this.status = -1;
        //             this.changeData(user_id);
        //         }
        //         let element = $(e.target);
        //         $(element.data('target')).modal('show');
        //     }
        // },
        showModal(e, user_id) {
            let option = e.target.options[e.target.options.selectedIndex].value;
            this.option = option;
            this.id_user = user_id;
            let element = $(e.target);
            $(element.data('target')).modal('show');
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
        sortListReport() {
            return this.listReports.sort((a,b) => {
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
.form-control {
    height: 38px;
}
button {
    margin-top: 33px;
}
input[type=number]::-webkit-inner-spin-button {
  -webkit-appearance: none;
}
</style>
