<template>
    <div>
          <div class="modal fade" id="detailReportModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail Report</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group">
                                <h4>Title : {{detail_report.title}}</h4>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            <label for="inputEmail4">Sender</label>
                            <input type="text" class="form-control" :value="detail_report.user.name" disabled>
                            </div>
                            <div class="form-group col-md-6">
                            <label for="inputPassword4">Receive</label>
                            <input type="text" class="form-control" :value="detail_report.assign_user[0].name" disabled>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1">Content</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" v-model="detail_report.content" disabled></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1">Status</label>
                                <span v-if="detail_report.status == 1" class="badge badge-success ml-3 text-white">Accept</span>
                                <span v-if="detail_report.status == 0" class="badge badge-primary ml-3">Pending</span>
                                <span v-if="detail_report.status == -1" class="badge badge-danger ml-3">Reject</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
            }
        },
        props: {
            detail_report: {
                type: Object,
            },
        },
    }
</script>

<style lang="scss" scoped>

</style>