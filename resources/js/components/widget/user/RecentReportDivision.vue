<template>
    <div class="col-md-12 col-lg-6">

        <div class="card">
            <div class="card-header">Recent User Report</div>
            <div class="card-body p-0">
                <ul class="todo-task-lists m-0 p-0">
                    <a v-for="report  in listReport" :key="report.id" :href="`#`" title="Show detail">
                        <li class="d-flex align-items-center p-3">

                            <div class="user-img img-fluid"><img :src="`images/users/${report.user.avatar}`"
                                                                 alt="story-img"
                                                                 class="rounded avatar-40"></div>
                            <div class="media-support-info ml-3">
                                <h6 class="d-inline-block">{{ report.title }}</h6>
                                <span v-if="report.status===1" class="badge badge-success ml-3 text-white">Accept</span>
                                <span v-else-if="report.status===-1"
                                      class="badge badge-danger ml-3 text-white">Reject</span>
                                <span v-else-if="report.status===0"
                                      class="badge badge-primary ml-3 text-white">Pending</span>
                                <p class="mb-0">Send: <a :href="`/profiles/${report.user.id}`">{{
                                        report.user.name
                                    }}</a>-Receive: <a
                                    :href="`/profiles/${report.assign_user[0].id}`">{{
                                        report.assign_user[0].name
                                    }}</a>
                                </p>
                            </div>

                        </li>
                    </a>
                </ul>
            </div>
            <div class="card-header">
                <h6 class="text-center"><a href="/admin/user-report" class="btn btn-primary">Show More</a></h6>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "RecentReportUser",
    data() {
        return {
            listReport: [],
        }
    },
    mounted() {
        this.getAllReport()
    },
    methods: {
        getAllReport() {
            axios.get('/api/admin/user-report')
                .then((response) => {
                    this.listReport = response.data.data;
                });
        }
    }
}
</script>

<style scoped>

</style>
