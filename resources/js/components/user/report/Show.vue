<template>
  <div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My report</li>
        </ol>
    </nav>
    <h3 class="mb-3 mt-3">My report / {{ report.id }}</h3>
    <div class="form-group">
        <label for="">Title:</label>
        <input type="text" class="form-control" :value="report.title" readonly>
    </div>
    <div class="form-group">
        <label for="">Content:</label>
        <textarea class="form-control" rows="5" :value="report.content" readonly></textarea>
    </div>
    <div class="form-group">
        <label for="">Created at:</label>
        <input type="text" class="form-control" :value="report.created_at|formatDate" readonly>
    </div>
    <div class="form-group">
        <label for="">Assign to:</label>
        <input type="text" class="form-control" :value="report.assign_user[0].name" readonly>
    </div>
    <div class="form-group">
        <label for="" class="mr-3">Status:</label>
        <span v-if="report.status == 1" class="btn btn-success btn-sm">Accept</span>
        <span v-if="report.status == 0" class="btn btn-primary btn-sm">Pending</span>
        <span v-if="report.status == -1" class="btn btn-danger btn-sm">Refure</span>
    </div>
    <div class="form-group" v-if="report.feedback">
        <label for="">Feedback from manager:</label>
        <input type="text" class="form-control" :value="report.feedback.message" readonly>
    </div>
    <div v-else></div>
  </div>
</template>

<script>
export default {
    props: ['report']
}
</script>

<style scoped>

</style>