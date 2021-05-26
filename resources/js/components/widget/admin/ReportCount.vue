<template>
    <div class="col-md-6 col-lg-3">
        <a href="/admin/user-report" title="Show detail">
            <div class="card card-block card-stretch card-height">
                <div class="card-body bg-danger-light rounded">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="rounded iq-card-icon bg-danger"><i class="fas fa-file-word"></i>
                        </div>
                        <div class="text-right">
                            <h2 class="mb-0"><span class="counter" style="visibility: visible;">{{ count }}</span></h2>
                            <h5 class="">Reports</h5>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</template>

<script>
export default {
    name: "ReportCount",
    data() {
        return {
            count: 0,
        }
    },
    mounted() {
        this.countReports();
    },
    methods: {
        countReports() {
            axios.get('/api/admin/get-reports')
                .then((response) => {

                    let countData = response.data.data.length;
                    this.count = countData;
                });
        }
    },
}
</script>

<style scoped>

</style>
