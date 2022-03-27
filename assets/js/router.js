import Vue from 'vue';
import VueRouter from 'vue-router'


Vue.use(VueRouter)

import Bookmarks from './vue/views/Bookmarks'
import CountryViewer from './vue/views/CountryViewer'
import Home from './vue/views/Home'
import Login from './vue/views/Login'
import Registration from './vue/views/Registration'
import Logout from './vue/views/Logout'
import History from './vue/views/History'
import Admin from './vue/views/Admin'
import VueTest from './vue/views/VueTest'
import NotFound from './vue/views/NotFound'

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/bookmarks', component: Bookmarks },
        { path: '/', component: Home },
        { path: '/login', component: Login },
        { path: '/country/:country', component: CountryViewer, props: true },
        { path: '/register', component: Registration },
        { path: '/logout', component: Logout },
        { path: '/history', component: History },
        { path: '/admin', component: Admin },
        { path: '/test', component: VueTest },
        { path: '*', component: NotFound },   
    ]
})

export default router;
