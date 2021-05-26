<template>
    <div class="col-md-12 col-lg-4">

        <div class="row">
            <div class="col-md-12">
                <a href="/user-reports/list" title="Show detail">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body bg-primary-light rounded">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="rounded iq-card-icon bg-primary"><i class="fas fa-box"></i>
                                </div>
                                <div class="text-right">
                                    <h2 class="mb-0"><span class="counter" style="visibility: visible;">{{
                                            count
                                        }}</span></h2>
                                    <h5 class="">My Report</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

    </div>
</template>

<script>
export default {
    name: "ReportCount",
    props: ['id'],
    data() {
        return {
            count: 0,
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
                    this.count = response.data.data.length;

                });
        }
    },
}
</script>

<style scoped>

</style>
