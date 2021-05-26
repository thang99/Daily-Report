<template>
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb iq-bg-primary">
                <li class="breadcrumb-item"><a href="/home"><i
                    class="ri-home-4-line mr-1 float-left"></i>Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Followers</li>
            </ol>
        </nav>
        <div class="row" v-if="listFollower.length > 0">
            <div v-for="follower in listFollower" :key="follower.id"
                 class="col-sm-6 col-md-6 col-lg-3">
                <div class="card card-block card-stretch card-height">
                    <div class="card-body">
                        <div class="subscriber-detail text-center">
                            <a :href="`/profiles/${follower.user_id}`">
                                <div class="image mb-2 position-relative d-inline-block">
                                    <img :src="`images/users/${follower.avatar}`" alt="profile"
                                         class="img-fluid rounded-circle avatar-100 text-center"
                                         :title="`Show profile ${follower.follow_name}`">

                                </div>

                                <h5 :title="`Show profile ${follower.follow_name}`">{{ follower.follow_name }}</h5>
                            </a>
                            <small class="mb-2">{{ follower.division_name }} - {{ follower.position_name }}</small>
                            <div class="d-flex align-items-center justify-content-center">
                                <!--                                <button class="btn btn-success rounded-small"><i class="ri-mail-line m-0"></i>-->
                                <!--                                </button>-->

                                <!--                                <btn-follow-component :user_id="follower.user_id"-->
                                <!--                                                      :follow_id="follower.follow_id"></btn-follow-component>-->
                                <div v-if="follower.status===1">
                                    <button v-on:click="unFollowUser(follower.user_id,follower.follow_id)"
                                            class="btn btn-danger">
                                        {{ followText }}
                                    </button>

                                </div>
                                <div v-else-if="follower.status===0">
                                    <button :key="follower.id"
                                            v-on:click="followUser(follower.user_id,follower.follow_id)"
                                            class="btn btn-primary">
                                        {{ followText }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-show="moreExsitUserFollow" class="mx-auto m-3">
                <a href="javascript:void(0);" class="btn btn-primary d-block mt-3"
                   v-on:click="loadMoreUserFollow"><i class="ri-add-line"></i> Load More</a>
            </div>
        </div>
        <div v-else>
            <h3 class="text-center ">You have not followed anyone yet!</h3>
            <p class="text-center"><a href="/suggests" class="btn btn-primary">Find new follower</a></p>
        </div>


    </div>
</template>

<script>
export default {
    name: "IndexComponent",
    props: {
        id: {
            type: Number,
        }
    },
    data() {
        return {
            followText: 'UnFollow',
            listFollower: [],
            totalPage: 0,
            per_page: 5,
            numberPage: 1,
            moreExsitUserFollow: false,
            nextPageUser: 0,
        }
    },
    mounted() {
        this.loadUserFollow();
    },
    methods: {
        async followUser(user_id, follower_id) {
            let data = {'user_id': follower_id, 'follow_id': user_id};
            await axios.post(`api/follows/follow`, data)
                .then((response) => {
                    this.followText = 'Follow';
                    this.loadUserFollow();

                }).catch(function (error) {
                    console.log(error);
                });
        },
        async unFollowUser(user_id, follower_id) {

            let data = {'user_id': user_id, 'follow_id': follower_id};
            if (confirm('Are you sure want to unfollow')) {
                await axios.post(`api/follows/unfollow`, data)
                    .then((response) => {
                        this.followText = 'UnFollow';
                        this.loadUserFollow();
                    }).catch(function (error) {
                        console.log(error);
                    });
            }
        },
        loadUserFollow() {
            axios.get(`/api/follows/${this.id}`)
                .then((response) => {
                    this.listFollower = response.data.data;
                    if (response.data.current_page < response.data.last_page) {
                        this.moreExsitUserFollow = true;
                        this.nextPageUser = response.data.current_page + 1;
                    } else {
                        this.moreExsitUserFollow = false;
                    }
                })
                .catch((err) => {
                    console.log('error!')
                });
        },
        loadMoreUserFollow() {
            axios.get(`/api/follows/${this.id}?page=${this.nextPageUser}`)
                .then((response) => {
                    console.log(response.data)
                    if (response.data.current_page < response.data.last_page) {
                        this.moreExsitUserFollow = true;
                        this.nextPageUser = response.data.current_page + 1;
                    } else {
                        this.moreExsitUserFollow = false;
                    }
                    response.data.data.forEach((data) => {
                        this.listFollower.push(data);
                    });
                })
                .catch((err) => {

                });
        },

    },


}
</script>

<style scoped>

</style>
