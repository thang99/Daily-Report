<template>
    <div class="col-md-12 col-lg-8">

        <div class="card">
                <div class="card-header">Recent Report</div>
            <div class="card-body p-0">
                <table class="table table-bordered table-responsive-md table-striped text-center">
                    <thead>
                    <tr>
                        <th>Title</th>
<!--                        <th style="width:500px">Content</th>-->
                        <th>Assign_to</th>
                        <th>Status</th>
                        <th>Created_at
                        </th>

                    </tr>
                    </thead>
                    <tbody v-if="this.listReport.length >0">

                    <tr v-for="report in listReport" :key="report.id">

                            <td>{{ report.title }}</td>
<!--                            <td style="width:500px">-->
<!--                                <span :title="report.content">{{ report.content | truncate(20, '...') }}</span>-->
<!--                            </td>-->
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

            </div>
            <div class="card-header" v-if="listReport.length>0">
                <h6 class="text-center"><a href="/user-reports/list" class="btn btn-primary">Show More</a></h6>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    props: ['id'],
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
            axios.get('/api/user-reports/list', {
                params: {
                    id: this.id
                }
            })
                .then((response) => {
                    this.listReport = response.data.data;

                });
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
}
</script>

<style scoped>

</style>
