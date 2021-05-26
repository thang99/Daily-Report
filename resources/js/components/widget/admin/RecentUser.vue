<template>
    <div class="col-md-12 col-lg-6">

        <div class="card">
            <div class="card-header">Recent User</div>
            <div class="card-body p-0">
                <ul class="todo-task-lists m-0 p-0">
                    <a v-for="user  in listUser" :key="user.id" :href="`/profiles/${user.id}`" title="Show detail">
                        <li class="d-flex align-items-center p-3">

                            <div class="user-img img-fluid"><img :src="`images/users/${user.avatar}`" alt="story-img"
                                                                 class="rounded avatar-40"></div>
                            <div class="media-support-info ml-3">
                                <h6 class="d-inline-block">{{ user.name }}</h6>
                                <span v-if="user.status===1" class="badge badge-success ml-3 text-white">Active</span>
                                <span v-if="user.status===0" class="badge badge-danger ml-3 text-white">Disabled</span>
                                <p class="mb-0">Created at: {{ user.created_at | formatDate }}</p>
                            </div>

                        </li>
                    </a>
                </ul>
            </div>
            <div class="card-header">
                <h6 class="text-center"><a href="/admin/manager-users" class="btn btn-primary">Show More</a></h6>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "RecentUser",
    data() {
        return {
            listUser: [],
        }
    },
    mounted() {
        this.getAllUser()
    },
    methods: {
        getAllUser() {
            axios.get('/api/admin/users')
                .then((response) => {
                    this.listUser = response.data.data;

                });
        }
    }
}
</script>

<style scoped>

</style>
