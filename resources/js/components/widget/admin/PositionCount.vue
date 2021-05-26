<template>
    <div class="col-md-6 col-lg-3">
        <a href="/admin/positions" title="Show detail">
            <div class="card card-block card-stretch card-height">
                <div class="card-body bg-warning-light rounded">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="rounded iq-card-icon bg-warning"><i class="fas fa-boxes"></i>
                        </div>
                        <div class="text-right">
                            <h2 class="mb-0"><span class="counter" style="visibility: visible;">{{ count }}</span></h2>
                            <h5 class="">Positions</h5>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</template>

<script>
export default {
    name: "PositionCount",
    data() {
        return {
            count: 0,
        }
    },
    mounted() {
        this.countPositions();
    },
    methods: {
        countPositions() {
            axios.get('/api/admin/positions')
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
