<template>
    <div class="col-md-12 col-lg-4">

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
