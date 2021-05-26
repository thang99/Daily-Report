<template>
<div class="container">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="/home">Home</a></li>
         <li class="breadcrumb-item active" aria-current="page">My profile</li>
      </ol>
   </nav>
    <div class="row">
        <div class="col-6">
               <div class="card card-block p-card" style="height:800px">
                  <div class="profile-box" style="height:600px">
                     <div class="profile-card rounded">
                        <img v-bind:src="'/images/users/'+user.avatar" alt="avatar" class="avatar-100 rounded d-block mx-auto img-fluid mb-3">
                        <h3 class="font-600 text-white text-center mb-2">{{ user.name }}</h3>
                        <div style="margin-bottom:90px" v-if="iduserlogin === id"></div>
                        <div class="mb-5" v-else>
                           <p class="text-white text-center" v-if="this.status === 1">
                              <button class="btn btn-secondary" @click="unfollowUser()"><i class="fas fa-user-check"></i>Followed</button>
                           </p>
                           <p class="text-white text-center" v-else>
                              <button class="btn btn-danger" @click="followUser()"><i class="fas fa-user-plus"></i>Follow</button>
                           </p>
                        </div>
                     </div>
                     <div class="pro-content rounded" style="height:320px">
                        <div class="d-flex align-items-center mb-3">
                           <div class="p-icon mr-3">
                              <i class="fas fa-birthday-cake"></i>
                           </div>
                           <p class="mb-0">{{ user.birthday }}</p>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                           <div class="p-icon mr-3">
                              <i class="fas fa-phone-square-alt"></i>
                           </div>
                           <p class="mb-0">{{ user.phone }}</p>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                           <div class="p-icon mr-3">
                             <i class="fas fa-envelope"></i>
                           </div>
                           <p class="mb-0">{{ user.email }}</p>
                        </div>
                        <div v-if="this.division.length>0 && this.position.length >0">
                           <div class="d-flex align-items-center mb-3">
                              <div class="p-icon mr-3">
                              <i class="fas fa-map-marker-alt"></i>
                              </div>
                              <p class="mb-0">{{ division[0].name }}</p>
                           </div>
                           <div class="d-flex align-items-center mb-3">
                              <div class="p-icon mr-3">
                                 <i class="fas fa-briefcase"></i>
                              </div>
                              <p class="mb-0">{{ position[0].name }}</p>
                           </div>
                        </div>
                        <div v-else>
                           <div class="d-flex align-items-center mb-3">
                              <div class="p-icon mr-3">
                              <i class="fas fa-map-marker-alt"></i>
                              </div>
                              <p class="mb-0">No division</p>
                           </div>
                           <div class="d-flex align-items-center mb-3">
                              <div class="p-icon mr-3">
                                 <i class="fas fa-briefcase"></i>
                              </div>
                              <p class="mb-0">No position</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                    <h4 class="card-title">List Reports</h4>
                    </div>
                </div>
                <div class="card-body">
                    <ul v-if="this.reports.length > 0">
                        <li class="report" v-for="report in reports" :key="report.id">
                           <div class="row">
                           <div class="card-transparent card-block card-stretch card-height blog">
                              <div class="card-body p-0">
                                 <div class="d-flex align-items-center">
                                    <div class="user-image">
                                       <img class="avatar-80 rounded" v-bind:src="'/images/users/'+user.avatar" alt="avatar">
                                    </div>
                                    <div class="ml-3">
                                       <h5>{{ report.user.name }}</h5>
                                       <small>{{ report.created_at | formatDate }}</small>
                                    </div>
                                 </div>
                                 <div class="blog-description mt-5">
                                    <span>{{ report.title }}</span>
                                    <p class="mt-4">{{ report.content }}</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <hr>
                        </li>
                           <div>
                              <nav aria-label="Page navigation example">
                                    <paginate
                                       :page-count="totalPage"
                                       :page-range="3"
                                       :margin-pages="2"
                                       :click-handler="clickCallBack"
                                       :prev-text="'Prev'"
                                       :next-text="'Next'"
                                       :container-class="'pagination justify-content-center'"
                                       :page-class="'page-item'"
                                       :page-link-class="'page-link'"
                                       :prev-class="'page-item'"
                                       :prev-link-class="'page-link'"
                                       :next-class="'page-item'"
                                       :next-link-class="'page-link'">
                                    </paginate>
                                 </nav>
                           </div>
                    </ul>
                    <ul v-else>
                        <li class="report text-center">No report here !!!</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin:30px 0px">
        <a class="btn btn-danger ml-3" href="/home">Back</a>
    </div>
</div>
</template>

<script>
export default {
    props: ['iduserlogin','user','position','division','id'],
    data() {
       return {
            reports : [],
            totalPage : 0,
            per_page : 5,
            pageNum : 1,
            status: null,
            toogle : true
       }
    },
    mounted () {
       this.selectTotalPage();
       this.clickCallBack();
       this.loadFollow();
    },

    methods: {
       selectTotalPage: function() {
         axios.get('/api/profiles',{
            params : {
               id: this.id,
               iduserlogin: this.iduserlogin
            }
         })
         .then((response) => {
            this.totalPage = response.data.last_page;
         });
        },
      clickCallBack: function (pageNum = 1) {
         axios.get(`/api/profiles?per_page=${this.per_page}&page=${pageNum}`, {
            params : {
               id: this.id,
               iduserlogin: this.iduserlogin
            }
         })
         .then((response) => {
            this.reports = response.data.data;
         })
         .catch((error) => {
            console.log(error);
         });
      },
      loadFollow() {
         axios.get('/api/loadFollow',{
            params : {
               id: this.id,
               iduserlogin: this.iduserlogin
            }
         })
         .then(response => {
            this.status = response.data;
         })
         .catch(error => {
            console.log(error);
         });
      },
      followUser() {
         axios.post('/api/follows/follow',{
            user_id: this.id,
            follow_id: this.iduserlogin,
         })
         .then(response => {
            this.status = response.data;
			   this.loadFollow();
         })
         .catch(error => {
            console.log(error);
         })
      },
      unfollowUser() {
         axios.post('/api/follows/unfollow',{
            user_id: this.id,
            follow_id: this.iduserlogin,
         })
         .then(response => {
            this.status = 0;
			   this.loadFollow();
         })
         .catch(error => {
            console.log(error);
         })
      },
    },
}
</script>

<style scoped>
img {
    height: 90px;
    width: 90px;
    border-radius: 50%;
}
li.info {
    list-style-type: none;
    height:50px;
    line-height: 50px;
}

li.report {
    list-style-type: none;
}
</style>
