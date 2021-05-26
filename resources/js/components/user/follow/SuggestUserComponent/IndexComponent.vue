<template>
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb iq-bg-primary">
                <li class="breadcrumb-item"><a href="/home"><i
                    class="ri-home-4-line mr-1 float-left"></i>Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Suggests</li>
            </ol>
        </nav>
        <div class="row" v-if="listFollower.length > 0">
            <div v-for="follower in listFollower" :key="follower.id" class="col-sm-6 col-md-6 col-lg-3">
                <div class="card card-block card-stretch card-height">
                    <div class="card-body">
                        <div class="subscriber-detail text-center">
                            <a :href="`/profiles/${follower.id}`">
                                <div class="image mb-2 position-relative d-inline-block">
                                    <img :src="`images/users/${follower.avatar}`" alt="profile"
                                         class="img-fluid rounded-circle avatar-100 text-center"
                                         :title="`Show profile ${follower.name}`">

                                </div>

                                <h5 :title="`Show profile ${follower.name}`">{{ follower.name }}</h5>
                            </a>
                            <small class="mb-2">{{ follower.division_name }} - {{ follower.position_name }}</small>
                            <div class="d-flex align-items-center justify-content-center">
                                <div>
                                    <button v-on:click="followUser(id,follower.id)"
                                            class="btn btn-primary">
                                        {{ followText }}
                                    </button>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-show="moreExsitSuggests" class="mx-auto m-3">
                <a href="javascript:void(0);" class="btn btn-primary d-block mt-3"
                   v-on:click="loadMoreSuggest"><i class="ri-add-line"></i> Load More</a>
            </div>
        </div>
        <div v-else>
            <h3 class="text-center ">There are no friends that are right for you, please come back later!</h3>
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
    data: function () {
        return {
            followText: 'Follow',
            listFollower: [],
            totalPage: 0,
            per_page: 5,
            numberPage: 1,
            moreExsitSuggests: false,
            nextPageUser: 0,
        }
    },
    mounted() {
        this.loadSuggestUser();
        // this.selectTotalPage();
        // this.clickCallBack();
    },
    methods: {
        async followUser(user_id, follower_id) {
            let data = {'user_id': follower_id, 'follow_id': user_id};
            await axios.post(`api/follows/follow`, data)
                .then((response) => {
                    this.followText = 'Follow';
                    this.loadSuggestUser();

                }).catch(function (error) {
                    console.log(error);
                });
        },
        async unFollowUser(user_id, follower_id) {

            let data = {'user_id': follower_id, 'follow_id': user_id};
            if (confirm('Are you sure want to unfollow')) {
                await axios.post(`api/follows/unfollow`, data)
                    .then((response) => {
                        this.followText = 'UnFollow';
                        this.loadSuggestUser();
                    }).catch(function (error) {
                        console.log(error);
                    });
            }
        },
        loadSuggestUser() {
            axios.get(`/api/suggests_follow/${this.id}`)
                .then((response) => {
                    this.listFollower = response.data.data;
                    if (response.data.current_page < response.data.last_page) {
                        this.moreExsitSuggests = true;
                        this.nextPageUser = response.data.current_page + 1;
                    } else {
                        this.moreExsitSuggests = false;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        loadMoreSuggest() {
            axios.get(`/api/suggests_follow/${this.id}?page=${this.nextPageUser}`)
                .then((response) => {
                    console.log(response.data)
                    if (response.data.current_page < response.data.last_page) {
                        this.moreExsitSuggests = true;
                        this.nextPageUser = response.data.current_page + 1;
                    } else {
                        this.moreExsitSuggests = false;
                    }
                    response.data.data.forEach((data) => {
                        this.listFollower.push(data);
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        // selectTotalPage: function () {
        //     axios.get(`/api/suggests_follow/${this.id}`)
        //         .then((response) => {
        //             this.totalPage = response.data.last_page;
        //         });
        // },
        // clickCallBack: function (pageNum = this.numberPage) {
        //     axios.get(`/api/suggests_follow/${this.id}?per_page=${this.per_page}&page=${pageNum}`)
        //         .then((response) => {
        //             this.listFollower = response.data.data;
        //             this.numberPage = pageNum;
        //         })
        //         .catch(function (error) {
        //             console.log(error);
        //         });
        // }
    },


}
</script>

<style scoped>

</style>
