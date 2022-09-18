import Vue from 'vue';
import VueRouter from 'vue-router';

import Login from '../pages/auth/Login.vue'
import Register from '../pages/auth/Register.vue'
import List from '../pages/conferences/List.vue'
import CreateConference from '../pages/conferences/CreateConference.vue'
import Details from '../pages/conferences/Details.vue'
import UpdateConference from '../pages/conferences/UpdateConference.vue'
import E403 from '../pages/errors/E403.vue'
import E404 from '../pages/errors/E404.vue'
import ReportsList from '../pages/reports/ReportsList.vue'
import ReportDetails from '../pages/reports/ReportDetails.vue'
import UpdateReport from '../pages/reports/UpdateReport.vue'
import Categories from '../pages/categories/CategoriesList.vue'
import CreateCategory from '../pages/categories/CreateCategory.vue'
import UpdateCategory from '../pages/categories/UpdateCategory.vue'
import CategoryDetails from '../pages/categories/CategoryDetails.vue'
import CreateSubcategory from '../pages/categories/CreateSubcategory.vue'
import Profile from '../pages/user/Profile.vue'
import ProfileEdit from '../pages/user/ProfileEdit.vue'
import UpdateSubcategory from '../pages/categories/UpdateSubcategory.vue'
import MeetingsList from '../pages/meetings/MeetingsList.vue'

import store from '../store'
//import store from '@/store/index.js'
//import { mapGetters } from 'vuex'
//import { mapActions } from 'vuex';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        { 
            path: '/error/403', 
            name: 'error_403', 
            component: E403
        },
        {
            path: '*',
            name: 'error_404',
            component: E404
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
        },
        {
            path: '/conferences-list',
            name: 'conferencesList',
            component: List,
        },
        {
            path: '/create-conference',
            name: 'createConference',
            component: CreateConference,
        },
        {
            path: '/details/:conferenceId',
            name: 'conferenceDetails',
            component: Details,
            props: true
        },
        {
            path: '/edit/:conferenceId',
            name: 'conferenceUpdate',
            component: UpdateConference,
            props: true
        },
        {
            path: '/reports',
            name: 'reports',
            component: ReportsList
        },
        {
            path: '/report/:reportId',
            name: 'reportDetails',
            component: ReportDetails,
            props: true
        },
        {
            path: '/report/edit/:reportId',
            name: 'updateReport',
            component: UpdateReport,
            props: true
        },
        {
            path: '/categories',
            name: 'categories',
            component: Categories,
        },
        {
            path: '/create-category',
            name: 'createCategory',
            component: CreateCategory,
        },
        {
            path: '/update-category/:categoryId',
            name: 'updateCategory',
            component: UpdateCategory,
            props: true
        },
        {
            path: '/category-details/:categoryId',
            name: 'categoryDetails',
            component: CategoryDetails,
            props: true
        },
        {
            path: '/create-subcategory/:categoryId',
            name: 'createSubcategory',
            component: CreateSubcategory,
            props: true
        },
        {
            path: '/profile',
            name: 'profile',
            component: Profile,
        },
        {
            path: '/profile/edit',
            name: 'profileEdit',
            component: ProfileEdit,
        },
        {
            path: '/update-subcategory/:subcategoryId',
            name: 'updateSubcategory',
            component: UpdateSubcategory,
            props: true
        },
        {
            path: '/meetings-list',
            name: 'meetingsList',
            component: MeetingsList
        }
    ]
});

router.beforeEach((to, from, next) => {
   // const token = store.getters.getCurrentUserToken
   // console.log(token)
    const role = store.getters.getCurrentUserRole
    const currentUserId = store.getters.getCurrentUserID
  //  console.log(router.app) ------
    
    //   console.log(currentUserId)
    //   console.log(role)
    const token = localStorage.getItem('x-xsrf-token')
    if(!token) {
        if(to.name === 'login' || to.name === 'register' || to.name === 'conferencesList') {
            return next()
        } else {
            return next({name: 'register'})
        }
    }

    if(token) {
     //   console.log(token)
 //       if(role === 'Announcer' && (to.name === 'conferenceUpdate' *** &&  !== currentUserId)) {
 //           return next({name: 'error_403'})
 //       }
        if((role === 'Listener' || role === 'Announcer') && (to.name === 'createCategory' || to.name === 'updateCategory' || to.name === 'createSubcategory' || to.name === 'updateSubcategory')) {
            return next({name: 'error_403'})
        }
        if(role === 'Listener' && (to.name === 'conferenceUpdate' || to.name === 'createConference')) {
            console.log(1)
            return next({name: 'error_403'})
        }
        if(to.name === 'login' || to.name === 'register') {
            console.log(222)
            return next({name: 'conferencesList'})
        }
    }

    next() 
})

export default router
