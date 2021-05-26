<template>
    <div class="col-md-6 col-lg-3">
        <a href="/admin/divisions" title="Show detail">
            <div class="card card-block card-stretch card-height">
                <div class="card-body bg-primary-light rounded">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="rounded iq-card-icon bg-primary"><i class="fas fa-box"></i>
                        </div>
                        <div class="text-right">
                            <h2 class="mb-0"><span class="counter" style="visibility: visible;">{{ count }}</span></h2>
                            <h5 class="">Divisions</h5>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</template>

<script>
export default {
    name: "DivisionCount",
    data() {
        return {
            count: 0,
        }
    },
    mounted() {
        this.countDivision();
    },
    methods: {
        countDivision() {
            axios.get('/api/admin/divisions')
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
