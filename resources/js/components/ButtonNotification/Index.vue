<template>
    <div>
        <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton"
           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div v-if="count>0">
                <i class="ri-notification-line bg-info p-2 rounded-small"> <span
                >{{ count }}</span></i>
            </div>
            <div v-else>
                <i class="ri-notification-line bg-info p-2 rounded-small"> <span
                ></span></i>
            </div>

        </a>
        <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton">
            <div class="card shadow-none m-0">
                <div class="card-body p-0 ">
                    <div class="cust-title p-3">
                        <h5 class="mb-0">All Notifications</h5>
                    </div>
                    <div v-for="noti in listNotification" :key="noti.id" class="p-3 menu-notification">
                        <a href="#" v-on:click="markAsRead(noti.id,noti.data.id)" class="iq-sub-card">
                            <div class="media align-items-center">
                                <!--                                <div class="">-->
                                <!--                                    <img class="avatar-40 rounded-small"-->
                                <!--                                         :src="`images/users/${noti.data.avatar}`"-->
                                <!--                                         alt="">-->
                                <!--                                </div>-->
                                <div class="media-body ml-3">
                                    <h6 class="mb-0">{{ noti.data.title }}
                                        <div v-if="noti.read_at ===null">
                                            <small class="badge badge-success float-right">New</small>
                                        </div>

                                    </h6>
                                    <p class="mb-0">{{ noti.data.message }}</p>
                                </div>
                            </div>
                        </a>

                    </div>
                    <a class="right-ic btn btn-primary btn-block position-relative p-2"
                       href="#" role="button">
                        <div class="dd-icon"><i class="las la-arrow-right mr-0"></i></div>
                        View All
                    </a>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import apiRequest from "../Api/index"

export default {
    name: "Index",
    props: {
        id: {
            type: Number,
        }
    },
    data() {
        return {
            listNotification: [],
            count: 0,
        }
    },
    mounted() {
        this.getListNotification();
        this.getRealTimeNotification();
        this.countUnReadNotification();
    },
    methods: {
        async getListNotification() {
            await apiRequest.getDataByElement('notification-list', `id=${this.id}`).then((response) => {
                this.listNotification = response.data.data;
            }).catch((error) => {
                console.log(error);
            });
            // await axios.get(`/api/notification-list`, {
            //     params: {
            //         id: this.id
            //     }
            // }).then((response) => {
            //
            //     this.listNotification = response.data.data;
            // }).catch((error) => {
            //     console.log(error);
            // });
        },
        getRealTimeNotification() {
            window.Echo.private(`App.Models.User.${this.id}`).notification((data) => {
                this.getListNotification();
                this.countUnReadNotification()
            })
        },
        async countUnReadNotification() {
            await apiRequest.getDataByElement('notification/unReadCount', `id=${this.id}`).then((response) => {
                this.count = response.data.data.count
            }).catch((error) => {
                console.log(error);
            });
            // await axios.get(`/api/notification/unReadCount`, {
            //     params: {
            //         id: this.id
            //     }
            // }).then((response) => {
            //     this.count = response.data.data.count
            // }).catch(function (error) {
            //     console.log(error);
            // });
        },
        async markAsRead(noti_id, id) {
            await axios.post('/api/mark-as-read', {
                noti_id: noti_id,
                id: id,
            }).then((response) => {
                this.getListNotification();
                this.countUnReadNotification();

                if (response.data.data.url) {
                    window.location.href = response.data.data.url;
                }
            }).catch((error) => {
                console.log(error);
            })
        }
    },
}
</script>

<style scoped>

</style>
