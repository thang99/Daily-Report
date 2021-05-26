<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="todo-date d-flex mr-3">
                                        <i class="ri-calendar-2-line text-success mr-2"></i>
                                        <span>{{ currentDateTime }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb iq-bg-primary">
                        <li class="breadcrumb-item"><a href="/home"><i
                            class="ri-home-4-line mr-1 float-left"></i>Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Report</li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="iq-todo-right">
                                    <form class="position-relative" @submit.prevent="searchReport" method="post">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control todo-search"
                                                           placeholder="Search report" v-model="formSearch.searchKey">
                                                    <a style="left:20px" class="search-link" href="#"><i
                                                        class="ri-search-line"></i></a>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="float-left mb-3 mr-2">
                                                    <select class="form-control mb-3" v-model="formSearch.status"
                                                            @change="searchReport">
                                                        <option value="2">All</option>
                                                        <option v-for="option in options" :key="option.value"
                                                                :value="option.value">{{ option.text }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""> From:</label>
                                                    <input type="date" class="form-control"
                                                           v-model="formSearch.startDate" id="startDateReport"
                                                           name="startDate" @change="searchReport">
                                                    <div class="text-danger" v-if="errors && errors.startDate">
                                                        {{ errors.startDate[0] }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">To:</label>
                                                    <input type="date" class="form-control" v-model="formSearch.endDate"
                                                           id="endDateReport" name="endDate" @change="searchReport">
                                                    <div class="text-danger" v-if="errors && errors.endDate">
                                                        {{ errors.endDate[0] }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="iq-todo-friendlist mt-3">
                                        <ul class="todo-task-lists m-0 p-0">
                                            <li v-for="report in listReport" :key="report.id"
                                                class="d-flex align-items-center p-3 " @click="showDetailReport(report)"
                                                data-toggle="modal">
                                                <div class="user-img img-fluid"><img
                                                    :src="`/images/users/${report.user.avatar}`" alt="story-img"
                                                    class="rounded avatar-40"></div>
                                                <div class="media-support-info ml-3">
                                                    <h6 class="d-inline-block">{{ report.title }}</h6>
                                                    <span v-if="report.status == status_user.active"
                                                          class="badge badge-success ml-3 text-white">Accept</span>
                                                    <span v-if="report.status == status_user.disabled" class="badge badge-primary ml-3">Pending</span>
                                                    <span v-if="report.status == status_user.block" class="badge badge-danger ml-3">Reject</span>
                                                    <p class="mb-0">Send {{ report.user.name }} - Receive
                                                        {{ report.assign_user[0].name }}</p>
                                                </div>
                                            </li>
                                        </ul>
                                        <div v-show="moreExsit">
                                            <a href="javascript:void(0);" class="btn btn-primary d-block mt-3"
                                               v-on:click="loadMoreReport"><i class="ri-add-line"></i> Load More</a>
                                        </div>
                                        <div v-show="moreExsitSearchReport">
                                            <a href="javascript:void(0);" class="btn btn-primary d-block mt-3"
                                               v-on:click="loadMoreSearchReport"><i class="ri-add-line"></i> Load More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="iq-todo-right">
                                    <form class="position-relative" @submit.prevent="searchRoleUser" method="post">
                                        <div class="form-group mb-0">
                                            <input type="text" class="form-control todo-search"
                                                   placeholder="Search user" v-model="formSearchUser.searchUser">
                                            <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                                        </div>
                                    </form>
                                    <div class="iq-todo-friendlist mt-3">
                                        <ul class="suggestions-lists m-0 p-0">
                                            <li class="d-flex mb-4 align-items-center" v-for="user in listUser"
                                                :key="user.id">
                                                <div class="user-img img-fluid"><img src="" alt="story-img"
                                                                                     class="rounded avatar-40"></div>
                                                <div class="media-support-info ml-3">
                                                    <h6><a :href="`/profiles/${user.id}`">{{ user.name }}</a></h6>
                                                    <p class="mb-0">{{user.created_at | formatDate}}</p>
                                                </div>

                                            </li>
                                        </ul>
                                        <div v-show="moreExsitUser">
                                            <a href="javascript:void(0);" class="btn btn-primary d-block"><i
                                                class="ri-add-line" v-on:click="loadMoreUser"></i> Load More</a>
                                        </div>
                                        <div v-show="moreExsitSearchUser">
                                            <a href="javascript:void(0);" class="btn btn-primary d-block"><i
                                                class="ri-add-line" v-on:click="loadMoreSearchUser"></i> Load More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="Object.keys(this.report).length > 0">
            <DetailReport :detail_report="report"></DetailReport>
        </div>
    </div>
</template>

<script>
import DetailReport from './DetailReport.vue';
import moment from 'moment';
import config from "../../../common/config";

export default {
    components: {
        DetailReport,
    },
    data() {
        return {
            formSearch: {
                startDate: '',
                endDate: '',
                status: 2,
                searchKey: '',
            },
            formSearchUser: {
                searchUser: '',
            },
            listReport: [],
            nextPage: 0,
            moreExsit: false,
            nextPageUser: 0,
            moreExsitUser: false,
            report: {},
            currentDateTime: '',
            errors: {},
            options: [
                {text: 'Pending', value: 0},
                {text: 'Accept', value: 1},
                {text: 'Reject', value: -1},
            ],
            listUser: [],
            status_user: [],
            moreExsitSearchReport : false,
            moreExsitSearchUser : false,
        }
    },
    mounted() {
        this.status_user = config.status_user
        this.loadReport();
        this.endDateTime();
        // this.startDateTime();
        this.currentDate();
        this.loadUser();
    },
    methods: {
        loadUser() {
            axios.get('/api/admin/all-role-user')
                .then((response) => {
                    this.listUser = response.data.data;
                    if (response.data.current_page < response.data.last_page) {
                        this.moreExsitUser = true;
                        this.nextPageUser = response.data.current_page + 1;
                    } else {
                        this.moreExsitUser = false;
                    }
                })
                .catch((error) => {
                     console.log(error);
                });
        },
        loadReport() {
            axios.get('/api/admin/user-report')
                .then((response) => {
                    this.listReport = response.data.data;
                    if (response.data.current_page < response.data.last_page) {
                        this.moreExsit = true;
                        this.nextPage = response.data.current_page + 1;
                    } else {
                        this.moreExsit = false;
                    }
                })
                .catch((error) => {
                     console.log(error);
                });
        },
        loadMoreReport() {
            axios.get(`/api/admin/user-report?page=${this.nextPage}`)
                .then((response) => {
                    if (response.data.current_page < response.data.last_page) {
                        this.moreExsit = true;
                        this.nextPage = response.data.current_page + 1;
                    } else {
                        this.moreExsit = false;
                    }
                    response.data.data.forEach(data => {
                        this.listReport.push(data);
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        loadMoreUser() {
            axios.get(`/api/admin/all-role-user?page=${this.nextPage}`)
                .then((response) => {
                    if (response.data.current_page < response.data.last_page) {
                        this.moreExsitUser = true;
                        this.nextPageUser = response.data.current_page + 1;
                    } else {
                        this.moreExsitUser = false;
                    }
                    response.data.data.forEach(data => {
                        this.listUser.push(data);
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        showDetailReport(report) {
            $('#detailReportModal').modal('show');
            this.report = report;
        },
        currentDate() {
            const current = new Date();
            this.currentDateTime = moment(current).format('dddd ,Do MMMM,YYYY')
        },
        endDateTime() {
            const current = new Date();
            // current.setDate(current.getDate() + 1);
            this.formSearch.endDate = moment(current).format('YYYY-MM-DD')
        },
        // startDateTime() {
        //     const current = new Date();
        //     current.setDate(current.getDate() - 7);
        //     this.formSearch.startDate = moment(current).format('YYYY-MM-DD')
        // },
        searchReport() {
            axios.post('/api/admin/user-report-search', this.formSearch)
                .then((response) => {
                    this.listReport = response.data.data;
                    if (response.data.current_page < response.data.last_page) {
                        this.moreExsitSearchReport = true;
                        this.nextPage = response.data.current_page + 1;
                    } else {
                        this.moreExsitSearchReport = false;
                    }
                    this.moreExsit = false;
                    this.errors = {}
                })
                .catch((errors) => {
                    if (errors && errors.response.status == 422) {
                        this.errors = errors.response.data.errors;
                    }
                });
        },
        searchRoleUser() {
            axios.post('/api/admin/user-search', this.formSearchUser)
                .then((response) => {
                    this.listUser = response.data.data;
                    if (response.data.current_page < response.data.last_page) {
                        this.moreExsitSearchUser = true;
                        this.nextPageUser = response.data.current_page + 1;
                    } else {
                        this.moreExsitSearchUser = false;
                    }
                     this.moreExsitUser = false;
                })
                .catch((errors) => {
                    console.log(errors)
                });
        },
        loadMoreSearchReport() {
             axios.post(`/api/admin/user-report-search?page=${this.nextPage}`, this.formSearch)
                .then((response) => {
                    if (response.data.current_page < response.data.last_page) {
                        this.moreExsitSearchReport = true;
                        this.moreExsitReport = false;
                        this.nextPage = response.data.current_page + 1;
                    } else {
                        this.moreExsitSearchReport = false;
                    }
                    response.data.data.forEach(data => {
                        this.listReport.push(data);
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        loadMoreSearchUser() {
             axios.post(`/api/admin/user-search?page=${this.nextPage}`, this.formSearchUser)
                .then((response) => {
                    if (response.data.current_page < response.data.last_page) {
                        this.moreExsitSearchUser = true;
                        this.moreExsitUser = false;
                        this.nextPage = response.data.current_page + 1;
                    } else {
                        this.moreExsitSearchUser = false;
                    }
                    response.data.data.forEach(data => {
                        this.listUser.push(data);
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
}
</script>

<style lang="scss" scoped>

</style>
