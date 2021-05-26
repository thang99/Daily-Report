import Paginate from 'vuejs-paginate'
import moment from 'moment'
import apiRequest from "./components/Api/index";
import Vue from 'vue';

require('./bootstrap');


window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//division
Vue.component('list-division-component', require('./components/admin/division/List.vue').default);

//role
Vue.component('form-create-role-component', require('./components/admin/role/CreateRoleComponent.vue').default);

//position
Vue.component('list-position-component', require('./components/admin/position/List.vue').default);

//position-division
Vue.component('list-position-division-component', require('./components/admin/position-division/List.vue').default);


//user
Vue.component('suggest-user-component', require('./components/user/follow/SuggestUserComponent/IndexComponent').default);
Vue.component('list-user-component', require('./components/admin/user/List.vue').default);
Vue.component('form-create-user-component', require('./components/admin/user/Create.vue').default);
Vue.component('form-edit-user-component', require('./components/admin/user/Edit.vue').default);
Vue.component('list-user-follow-component', require('./components/user/follow/UserFollowComponent/IndexComponent').default);
Vue.component('list-user-division-component', require('./components/admin/user-division/List.vue').default);
Vue.component('list-user-report-component', require('./components/admin/user-report/List.vue').default);

Vue.component('list-report', require('./components/manager/report/Index.vue').default);

//user
Vue.component('suggest-user-component', require('./components/user/follow/SuggestUserComponent/IndexComponent').default);
Vue.component('list-user-follow-component', require('./components/user/follow/UserFollowComponent/IndexComponent').default)

Vue.component('list-user', require('./components/manager/user/Index.vue').default);
Vue.component('create-user', require('./components/manager/user/Create.vue').default);
Vue.component('edit-user', require('./components/manager/user/Edit.vue').default);

Vue.component('list-report', require('./components/manager/report/Index.vue').default);
//user-report
Vue.component('list-report-user-component', require('./components/user/report/Index.vue').default);
Vue.component('form-create-report-component', require('./components/user/report/Create.vue').default);
Vue.component('form-edit-report-component', require('./components/user/report/Edit.vue').default);
Vue.component('show-detail-report', require('./components/user/report/Show.vue').default);
Vue.component('show-report-division', require('./components/user/report/ListReportDivision.vue').default);


// view profile

Vue.component('user-profile', require('./components/profile/UserProfile.vue').default);
Vue.component('edit-profile', require('./components/profile/EditProfile.vue').default);
Vue.component('edit-password', require('./components/profile/EditPassword.vue').default);


Vue.component('btn-notification', require('./components/ButtonNotification/Index.vue').default);

Vue.component('paginate', Paginate);
//social

Vue.component('auth-facebook', require('./components/socialite/Facebook.vue').default);
Vue.component('auth-google', require('./components/socialite/Google.vue').default);
//auth
Vue.component('auth-login', require('./components/auth/Login.vue').default);
//Widget Admin
Vue.component('widget-admin-division', require('./components/widget/admin/DivisionCount').default);
Vue.component('widget-admin-position', require('./components/widget/admin/PositionCount').default);
Vue.component('widget-admin-user', require('./components/widget/admin/RecentUser').default);
Vue.component('widget-admin-manager-division', require('./components/widget/admin/ManagerDivisionCount').default);
Vue.component('widget-admin-report', require('./components/widget/admin/RecentReport').default);
Vue.component('widget-admin-report-count', require('./components/widget/admin/ReportCount').default);
Vue.component('widget-admin-user-count', require('./components/widget/admin/UserCount').default);
//Widget Manager
Vue.component('widget-manager-report-user', require('./components/widget/manager/RecentReportUser').default);
Vue.component('widget-manager-user-division-count', require('./components/widget/manager/UserDivisionCount').default);
Vue.component('widget-manager-user-division', require('./components/widget/manager/RecentUserDivision').default);
//Widget User
Vue.component('widget-user-report', require('./components/widget/user/RecentReport').default);
Vue.component('widget-user-report-count', require('./components/widget/user/ReportCount').default);
Vue.component('widget-report-division', require('./components/widget/user/RecentReportDivision').default);
//
Vue.component('widget-follower-count', require('./components/widget/RecentFollow').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.filter('formatDate', function (value) {
    if (value) {
        return moment(String(value)).format('MM/DD/YYYY HH:mm')
    }
});
const app = new Vue({
    el: '#app',
});



